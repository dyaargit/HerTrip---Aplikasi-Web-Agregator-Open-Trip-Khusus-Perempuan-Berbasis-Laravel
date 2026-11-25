
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Organizer
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('admin.organizers.update', $organizer) }}"
                  method="POST"
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nama Organizer
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $organizer->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                           required>

                    @error('name')
                        <p class="text-red-600 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nomor WhatsApp Organizer
                    </label>

                    <input type="text"
                           name="contact"
                           value="{{ old('contact', $organizer->contact) }}"
                           placeholder="Contoh: 081234567890"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                           required>

                    <p class="text-xs text-gray-500 mt-1">
                        Masukkan nomor WhatsApp aktif organizer.
                    </p>

                    @error('contact')
                        <p class="text-red-600 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Status Verifikasi
                    </label>

                    <select name="verification_status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            required>
                        <option value="pending"
                            {{ old('verification_status', $organizer->verification_status) === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="verified"
                            {{ old('verification_status', $organizer->verification_status) === 'verified' ? 'selected' : '' }}>
                            Verified
                        </option>
                    </select>

                    @error('verification_status')
                        <p class="text-red-600 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">
                        Update Organizer
                    </button>

                    <a href="{{ route('admin.organizers.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm hover:bg-gray-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>