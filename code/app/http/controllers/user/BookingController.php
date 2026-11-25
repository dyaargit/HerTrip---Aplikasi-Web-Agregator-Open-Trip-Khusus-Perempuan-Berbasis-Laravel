<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Bookings::with(['trip', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }

    public function store(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            DB::transaction(function () use ($request, $trip, $validated) {
                $lockedTrip = Trip::lockForUpdate()->findOrFail($trip->id);

                $bookedQuantity = (int) $lockedTrip->bookings()
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->sum('quantity');

                $remainingQuota = max(0, (int) $lockedTrip->quota - $bookedQuantity);

                if ($validated['quantity'] > $remainingQuota) {
                    throw new \RuntimeException("Kuota tidak mencukupi. Sisa kuota: {$remainingQuota} peserta.");
                }

                $totalPrice = (int) $lockedTrip->price * (int) $validated['quantity'];

                Bookings::create([
                    'user_id' => $request->user()->id,
                    'trip_id' => $lockedTrip->id,
                    'quantity' => $validated['quantity'],
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['quantity' => $e->getMessage()])->withInput();
        }

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking berhasil dibuat! Silakan unggah bukti pembayaran.');
    }
}