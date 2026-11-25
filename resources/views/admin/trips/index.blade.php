<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Paket Trip
            </h2>
            <a href="{{ route('admin.trips.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                + Tambah Trip
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
                        <th class="py-2">Judul Trip</th>
                        <th class="py-2">Kategori</th>
                        <th class="py-2">Organizer</th>
                        <th class="py-2">Destinasi</th>
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">Harga</th>
                        <th class="py-2">Kuota</th>
                        <th class="py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trips as $trip)
                        <tr class="border-b">
                            <td class="py-2">{{ $loop->iteration }}</td>
                            <td class="py-2 font-medium">{{ $trip->title }}</td>
                            <td class="py-2">{{ $trip->category?->category_name ?? '-' }}</td>
                            <td class="py-2">{{ $trip->organizer?->name ?? '-' }}</td>
                            <td class="py-2">{{ $trip->destination }}</td>
                            <td class="py-2">{{ $trip->date }}</td>
                            <td class="py-2">Rp {{ number_format($trip->price, 0, ',', '.') }}</td>
                            <td class="py-2">{{ $trip->quota }}</td>
                            <td class="py-2 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.trips.edit', $trip) }}" class="text-blue-600 hover:underline">
                                    Edit
                                </a>
                                <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" class="inline" onsubmit="return confirm('Hapus paket trip ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-4 text-center text-gray-500">Belum ada paket trip.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>