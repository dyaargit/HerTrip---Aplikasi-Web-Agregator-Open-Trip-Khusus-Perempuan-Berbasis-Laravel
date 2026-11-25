
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Katalog Paket Trip HerTrip
            </h2>

            <a href="{{ route('user.bookings.index') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                Booking Saya
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Form Pencarian dan Filter --}}
        <form method="GET"
              action="{{ route('user.trips.index') }}"
              class="bg-white shadow-sm sm:rounded-lg p-4 grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Cari Trip / Destinasi
                </label>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Contoh: Prau, Labuan Bajo..."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Kategori
                </label>

                <select name="category_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                    <option value="">Semua Kategori</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                    Filter
                </button>

                <a href="{{ route('user.trips.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm hover:bg-gray-300">
                    Reset
                </a>
            </div>
        </form>

        {{-- Daftar Kartu Trip --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($trips as $trip)

                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between space-y-4">

                    {{-- Informasi Trip --}}
                    <div class="space-y-2">

                        <div class="flex items-center justify-between text-xs text-indigo-600 font-semibold">
                            <span>
                                {{ $trip->category?->category_name ?? 'Umum' }}
                            </span>

                            <span>
                                {{ $trip->date }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $trip->title }}
                        </h3>

                        <p class="text-sm text-gray-600">
                            Destinasi: {{ $trip->destination }}
                        </p>

                        <p class="text-xs text-gray-500">
                            Organizer: {{ $trip->organizer?->name ?? '-' }}
                        </p>

                        <p class="text-sm text-gray-700">
                            {{ $trip->description }}
                        </p>

                    </div>

                    {{-- Harga dan Tombol Detail --}}
                    <div class="pt-4 border-t flex flex-col gap-3">

                        <div>
                            <p class="text-xs text-gray-500">
                                Harga / orang
                            </p>

                            <p class="text-base font-bold text-gray-900">
                                Rp {{ number_format($trip->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <a href="{{ route('user.trips.show', ['trip' => $trip->id]) }}"
                           style="display: block; background-color: #ffffff; color: #4f46e5 !important; border: 2px solid #4f46e5; text-align: center; padding: 12px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none;">

                            Lihat Detail & Booking

                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-3 bg-white shadow-sm sm:rounded-lg p-8 text-center text-gray-500">
                    Tidak ada paket trip yang ditemukan.
                </div>

            @endforelse

        </div>
    </div>
</x-app-layout>
