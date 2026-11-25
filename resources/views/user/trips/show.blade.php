<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Paket Trip
            </h2>
            <a href="{{ route('user.trips.index') }}" class="text-sm text-indigo-600 hover:underline">
                &larr; Kembali ke Katalog
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
            <div class="text-xs font-semibold text-indigo-600">
                {{ $trip->category?->category_name ?? 'Umum' }}
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $trip->title }}</h1>

            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>Destinasi:</strong> {{ $trip->destination }}</p>
                <p><strong>Tanggal Keberangkatan:</strong> {{ $trip->date }}</p>
                <p><strong>Organizer:</strong> {{ $trip->organizer?->name ?? '-' }} ({{ $trip->organizer?->contact ?? '-' }})</p>
                <p><strong>Kuota Total:</strong> {{ $trip->quota }} orang | <strong>Sisa Kuota:</strong> {{ $remainingQuota }} orang</p>
            </div>

            <div class="pt-4 border-t">
                <h3 class="font-semibold text-gray-800 mb-2">Deskripsi Perjalanan</h3>
                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $trip->description }}</p>
            </div>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4 h-fit">
            <div>
                <p class="text-xs text-gray-500">Harga per peserta</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($trip->price, 0, ',', '.') }}</p>
            </div>

            @if($remainingQuota > 0)
                <form action="{{ route('user.bookings.store', $trip) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Peserta</label>
                        <input type="number" name="quantity" min="1" max="{{ $remainingQuota }}" value="{{ old('quantity', 1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        @error('quantity')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                        Booking Sekarang
                    </button>
                </form>
            @else
                <div class="p-3 bg-red-100 text-red-800 rounded-md text-sm">
                    Kuota trip ini sudah penuh.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>