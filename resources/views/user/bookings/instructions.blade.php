
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instruksi Pembayaran
            </h2>

            <a href="{{ route('user.bookings.index') }}"
               class="text-sm text-indigo-600 hover:underline">
                &larr; Daftar Booking Saya
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ringkasan Booking --}}
        <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">

            <div>
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                    Booking #{{ $booking->id }}
                </span>

                <h3 class="text-xl font-bold text-gray-900 mt-3">
                    {{ $booking->trip?->title ?? 'Trip' }}
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                <div>
                    <p class="text-gray-500">Destinasi</p>
                    <p class="font-medium text-gray-800">
                        {{ $booking->trip?->destination ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Tanggal Trip</p>
                    <p class="font-medium text-gray-800">
                        {{ $booking->trip?->date ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Jumlah Peserta</p>
                    <p class="font-medium text-gray-800">
                        {{ $booking->quantity }} orang
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Status Booking</p>
                    <p class="font-medium text-gray-800 capitalize">
                        {{ $booking->status }}
                    </p>
                </div>

            </div>

            <div class="border-t pt-4">
                <p class="text-sm text-gray-500">
                    Total Pembayaran
                </p>

                <p class="text-2xl font-bold text-indigo-700">
                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Informasi Pembayaran --}}
        <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">

            <div>
                <h3 class="text-lg font-bold text-gray-900">
                    Langkah Selanjutnya
                </h3>

                <p class="text-sm text-gray-600 mt-1">
                    Pembayaran dilakukan secara langsung kepada organizer
                    trip, bukan melalui HerTrip.
                </p>
            </div>

            {{-- Organizer --}}
            <div class="p-4 bg-gray-50 border rounded-lg">
                <p class="text-sm text-gray-500">
                    Penyelenggara Trip
                </p>

                <p class="font-semibold text-gray-900 mt-1">
                    {{ $organizer?->name ?? 'Organizer belum tersedia' }}
                </p>

                @if($organizer && $whatsappUrl)
                    <p class="text-sm text-gray-600 mt-2">
                        Hubungi organizer untuk mengonfirmasi booking,
                        mendapatkan informasi rekening, dan menyelesaikan
                        pembayaran.
                    </p>

                    <a href="{{ $whatsappUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="mt-4 inline-flex items-center justify-center w-full sm:w-auto px-5 py-3 bg-green-600 text-white rounded-lg font-semibold text-sm hover:bg-green-700">
                        Hubungi Organizer via WhatsApp
                    </a>
                @else
                    <div class="mt-3 p-3 bg-yellow-100 text-yellow-800 rounded-md text-sm">
                        Kontak WhatsApp organizer belum tersedia.
                        Silakan hubungi admin HerTrip untuk informasi lebih lanjut.
                    </div>
                @endif
            </div>

            {{-- Petunjuk --}}
            <div class="space-y-3">
                <h4 class="font-semibold text-gray-800">
                    Panduan Pembayaran
                </h4>

                <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                    <li>
                        Klik tombol Hubungi Organizer via WhatsApp.
                    </li>

                    <li>
                        Konfirmasi detail booking dan jumlah pembayaran
                        kepada organizer.
                    </li>

                    <li>
                        Lakukan pembayaran sesuai instruksi organizer.
                    </li>

                    <li>
                        Setelah pembayaran berhasil, kembali ke halaman ini.
                    </li>

                    <li>
                        Upload bukti transfer melalui HerTrip agar pembayaran
                        dapat diverifikasi oleh admin.
                    </li>
                </ol>
            </div>

            <div class="p-3 bg-blue-50 border border-blue-100 rounded-md text-sm text-blue-800">
                HerTrip tidak memproses pembayaran secara langsung.
                Pembayaran dilakukan antara peserta dan organizer.
                Bukti pembayaran tetap perlu diunggah ke HerTrip
                untuk proses verifikasi.
            </div>
        </div>

        {{-- Status dan Upload --}}
        <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-3">

            @if(!$booking->payment || $booking->payment->verification_status === 'rejected')

                <a href="{{ route('user.payments.create', $booking) }}"
                   class="block w-full text-center px-5 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">
                    {{ $booking->payment?->verification_status === 'rejected'
                        ? 'Upload Ulang Bukti Pembayaran'
                        : 'Upload Bukti Pembayaran' }}
                </a>

            @elseif($booking->payment->verification_status === 'pending')

                <div class="p-3 bg-yellow-100 text-yellow-800 rounded-md text-sm">
                    Bukti pembayaran sudah dikirim dan sedang menunggu
                    verifikasi admin.
                </div>

            @elseif($booking->payment->verification_status === 'verified')

                <div class="p-3 bg-green-100 text-green-800 rounded-md text-sm">
                    Pembayaran telah diverifikasi. Booking Anda telah
                    dikonfirmasi.
                </div>

            @endif

            <a href="{{ route('user.bookings.index') }}"
               class="block w-full text-center px-5 py-3 bg-gray-200 text-gray-800 rounded-lg font-medium hover:bg-gray-300">
                Kembali ke Daftar Booking
            </a>
        </div>

    </div>
</x-app-layout>