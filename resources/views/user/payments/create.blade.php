
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Upload Bukti Pembayaran
            </h2>

            <a href="{{ route('user.bookings.index') }}"
               style="color: #4f46e5; text-decoration: none; font-size: 14px;">
                &larr; Kembali ke Booking Saya
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">

            {{-- Informasi Booking --}}
            <div class="border-b pb-4 text-sm text-gray-700 space-y-1">
                <p><strong>Paket Trip:</strong> {{ $booking->trip?->title ?? '-' }}</p>
                <p><strong>Jumlah Peserta:</strong> {{ $booking->quantity }}</p>
                <p><strong>Total Tagihan:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>

                @if($booking->payment?->verification_status === 'rejected')
                    <p style="color: #dc2626; font-weight: 600; padding-top: 4px;">
                        Bukti pembayaran sebelumnya ditolak. Silakan unggah ulang bukti transfer yang valid.
                    </p>
                @endif
            </div>

            {{-- Form Upload --}}
            <form action="{{ route('user.payments.store', $booking) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-4">

                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Bukti Transfer (JPG, JPEG, PNG, WEBP — maks. 2MB)
                    </label>

                    <input type="file"
                           name="payment_proof"
                           accept="image/jpeg,image/png,image/webp"
                           class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md p-2"
                           required>

                    @error('payment_proof')
                        <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Preview Bukti Sebelumnya --}}
                @if($booking->payment?->payment_proof)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Bukti saat ini:</p>

                        <img src="{{ asset('storage/' . $booking->payment->payment_proof) }}"
                             alt="Bukti Pembayaran"
                             class="max-h-60 rounded border">
                    </div>
                @endif

                {{-- Tombol --}}
                <div style="display: flex; gap: 12px; margin-top: 20px;">

                    <button type="submit"
                            style="
                                display: inline-block;
                                background: #4f46e5 !important;
                                background-color: #4f46e5 !important;
                                color: #ffffff !important;
                                border: 2px solid #4f46e5 !important;
                                padding: 12px 20px !important;
                                border-radius: 8px !important;
                                font-size: 14px !important;
                                font-weight: 700 !important;
                                opacity: 1 !important;
                                cursor: pointer;
                                text-align: center;
                            ">
                        Kirim Bukti Pembayaran
                    </button>

                    <a href="{{ route('user.bookings.index') }}"
                       style="
                            display: inline-block;
                            background: #e5e7eb !important;
                            color: #1f2937 !important;
                            border: 2px solid #d1d5db;
                            padding: 12px 20px;
                            border-radius: 8px;
                            font-size: 14px;
                            font-weight: 700;
                            text-decoration: none;
                            text-align: center;
                       ">
                        Batal
                    </a>

                </div>

            </form>
        </div>
    </div>
</x-app-layout>
