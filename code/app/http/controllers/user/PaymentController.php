<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function create(Bookings $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        $booking->load(['trip', 'payment']);

        return view('user.payments.create', compact('booking'));
    }

    public function store(Request $request, Bookings $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($booking->payment && $booking->payment->payment_proof) {
            Storage::disk('public')->delete($booking->payment->payment_proof);
        }

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        Payments::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'payment_proof' => $path,
                'verification_status' => 'pending',
                'verified_by' => null,
                'verified_at' => null,
            ]
        );

        $booking->update([
            'status' => 'pending',
        ]);

        return redirect()->route('user.bookings.index')
            ->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi admin.');
    }
}