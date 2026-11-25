<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Paket Trip
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('admin.trips.update', $trip) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Judul Trip</label>
                    <input type="text" name="title" value="{{ old('title', $trip->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    @error('title')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $trip->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Organizer</label>
                        <select name="organizer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach($organizers as $organizer)
                                <option value="{{ $organizer->id }}" {{ old('organizer_id', $trip->organizer_id) == $organizer->id ? 'selected' : '' }}>
                                    {{ $organizer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('organizer_id')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Destinasi</label>
                        <input type="text" name="destination" value="{{ old('destination', $trip->destination) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        @error('destination')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="date" value="{{ old('date', $trip->date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        @error('date')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                        <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $trip->price) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        @error('price')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kuota</label>
                        <input type="number" name="quota" min="1" value="{{ old('quota', $trip->quota) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        @error('quota')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('description', $trip->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                        Update
                    </button>
                    <a href="{{ route('admin.trips.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm hover:bg-gray-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>