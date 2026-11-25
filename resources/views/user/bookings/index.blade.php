
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Booking Saya
            </h2>

            <a href="{{ route('user.trips.index') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">
                + Cari Trip Lain
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="border-b text-gray-700">
                        <th class="py-3 px-2">#</th>
                        <th class="py-3 px-2">Paket Trip</th>
                        <th class="py-3 px-2">Tanggal Trip</th>
                        <th class="py-3 px-2">Jumlah</th>
                        <th class="py-3 px-2">Total Harga</th>
                        <th class="py-3 px-2">Status Booking</th>
                        <th class="py-3 px-2">Status Bayar</th>
                        <th class="py-3 px-2 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($bookings as $booking)

                        <tr class="border-b">

                            <td class="py-4 px-2">
                                {{ $loop->iteration }}
                            </td>

                            <td class="py-4 px-2 font-medium">
                                {{ $booking->trip?->title ?? '-' }}
                            </td>

                            <td class="py-4 px-2">
                                {{ $booking->trip?->date ?? '-' }}
                            </td>

                            <td class="py-4 px-2">
                                {{ $booking->quantity }}
                            </td>

                            <td class="py-4 px-2 whitespace-nowrap">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </td>

                            <td class="py-4 px-2 capitalize">
                                {{ $booking->status }}
                            </td>

                            <td class="py-4 px-2 capitalize">
                                {{ $booking->payment?->verification_status ?? 'belum bayar' }}
                            </td>

                            <td class="py-4 px-2">
                                <div class="flex flex-col gap-2 min-w-[150px]">

                                    <a href="{{ route('user.payments.instructions', $booking) }}"
                                       class="block text-center px-3 py-2 bg-purple-600 text-white rounded-md text-xs font-semibold hover:bg-purple-700">
                                        Instruksi Pembayaran
                                    </a>

                                    @if(!$booking->payment || $booking->payment->verification_status === 'rejected')

                                        <a href="{{ route('user.payments.create', $booking) }}"
                                           class="block text-center px-3 py-2 bg-indigo-600 text-white rounded-md text-xs font-semibold hover:bg-indigo-700">
                                            {{ $booking->payment?->verification_status === 'rejected'
                                                ? 'Upload Ulang Bukti'
                                                : 'Upload Bukti' }}
                                        </a>

                                    @elseif($booking->payment->verification_status === 'pending')

                                        <span class="text-center px-3 py-2 bg-yellow-100 text-yellow-800 rounded-md text-xs font-medium">
                                            Menunggu Verifikasi
                                        </span>

                                    @elseif($booking->payment->verification_status === 'verified')

                                        <span class="text-center px-3 py-2 bg-green-100 text-green-800 rounded-md text-xs font-medium">
                                            Pembayaran Verified
                                        </span>

                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8"
                                class="py-8 text-center text-gray-500">
                                Kamu belum memiliki booking.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>