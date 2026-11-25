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
            $booking = DB::transaction(function () use ($request, $trip, $validated) {

                $lockedTrip = Trip::lockForUpdate()->findOrFail($trip->id);

                $bookedQuantity = (int) $lockedTrip->bookings()
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->sum('quantity');

                $remainingQuota = max(
                    0,
                    (int) $lockedTrip->quota - $bookedQuantity
                );

                if ($validated['quantity'] > $remainingQuota) {
                    throw new \RuntimeException(
                        "Kuota tidak mencukupi. Sisa kuota: {$remainingQuota} peserta."
                    );
                }

                $totalPrice = (int) $lockedTrip->price
                    * (int) $validated['quantity'];

                return Bookings::create([
                    'user_id' => $request->user()->id,
                    'trip_id' => $lockedTrip->id,
                    'quantity' => $validated['quantity'],
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                ]);
            });

        } catch (\RuntimeException $e) {

            return back()
                ->withErrors(['quantity' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('user.payments.instructions', $booking)
            ->with('success', 'Booking berhasil dibuat!');
    }

    public function instructions($bookingId)
    {
        $booking = Bookings::with([
            'trip.organizer',
            'payment',
        ])
            ->where('user_id', auth()->id())
            ->findOrFail($bookingId);

        $organizer = $booking->trip?->organizer;

        $whatsappNumber = $organizer?->contact;

        if ($whatsappNumber) {
            $whatsappNumber = preg_replace(
                '/\D/',
                '',
                $whatsappNumber
            );

            if (str_starts_with($whatsappNumber, '0')) {
                $whatsappNumber = '62' . substr($whatsappNumber, 1);
            } elseif (!str_starts_with($whatsappNumber, '62')) {
                $whatsappNumber = '62' . $whatsappNumber;
            }
        }

        $whatsappMessage = urlencode(
            "Halo {$organizer?->name}, saya ingin mengonfirmasi booking trip "
            . "{$booking->trip?->title}. "
            . "Booking ID: {$booking->id}. "
            . "Jumlah peserta: {$booking->quantity} orang. "
            . "Total pembayaran: Rp "
            . number_format($booking->total_price, 0, ',', '.')
            . ". Mohon informasi pembayaran selanjutnya. Terima kasih."
        );

        $whatsappUrl = $whatsappNumber
            ? "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}"
            : null;

        return view('user.bookings.instructions', compact(
            'booking',
            'organizer',
            'whatsappUrl'
        ));
    }
}