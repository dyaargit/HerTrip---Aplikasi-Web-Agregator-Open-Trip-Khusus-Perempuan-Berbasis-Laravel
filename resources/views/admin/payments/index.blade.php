<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Verifikasi Pembayaran
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-indigo-600 hover:underline">
                &larr; Dashboard Admin
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">#</th>
                        <th class="py-2">User</th>
                        <th class="py-2">Trip</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Bukti</th>
                        <th class="py-2">Status</th>
                        <th class="py-2 text-right">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr class="border-b align-top">
                            <td class="py-2">{{ $loop->iteration }}</td>
                            <td class="py-2">{{ $payment->booking?->user?->name ?? '-' }}</td>
                            <td class="py-2">{{ $payment->booking?->trip?->title ?? '-' }}</td>
                            <td class="py-2">Rp {{ number_format($payment->booking?->total_price ?? 0, 0, ',', '.') }}</td>
                            <td class="py-2">
                                @if($payment->payment_proof)
                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-indigo-600 hover:underline text-sm">
                                        Lihat Bukti
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-2 capitalize">{{ $payment->verification_status }}</td>
                            <td class="py-2 text-right whitespace-nowrap space-x-2">
                                <form action="{{ route('admin.payments.update', $payment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="verification_status" value="verified">
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                                        Verify
                                    </button>
                                </form>

                                <form action="{{ route('admin.payments.update', $payment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="verification_status" value="rejected">
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                        Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-gray-500">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>