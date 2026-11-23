<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payments::with(['booking.user', 'booking.trip', 'verifier'])
            ->latest()
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    public function update(Request $request, Payments $payment)
    {
        $validated = $request->validate([
            'verification_status' => ['required', 'in:verified,rejected'],
        ]);

        $payment->update([
            'verification_status' => $validated['verification_status'],
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        if ($payment->booking) {
            $payment->booking->update([
                'status' => $validated['verification_status'] === 'verified' ? 'confirmed' : 'rejected',
            ]);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}