<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Organizer
            </h2>
            <a href="{{ route('admin.organizers.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                + Tambah Organizer
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">#</th>
                        <th class="py-2">Nama Organizer</th>
                        <th class="py-2">Kontak</th>
                        <th class="py-2">Status Verifikasi</th>
                        <th class="py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($organizers as $organizer)
                        <tr class="border-b">
                            <td class="py-2">{{ $loop->iteration }}</td>
                            <td class="py-2">{{ $organizer->name }}</td>
                            <td class="py-2">{{ $organizer->contact }}</td>
                            <td class="py-2 capitalize">{{ $organizer->verification_status }}</td>
                            <td class="py-2 text-right space-x-2">
                                <a href="{{ route('admin.organizers.edit', $organizer) }}" class="text-blue-600 hover:underline">
                                    Edit
                                </a>
                                <form action="{{ route('admin.organizers.destroy', $organizer) }}" method="POST" class="inline" onsubmit="return confirm('Hapus organizer ini?')">
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
                            <td colspan="5" class="py-4 text-center text-gray-500">Belum ada organizer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>