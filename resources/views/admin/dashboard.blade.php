<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin HerTrip
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-900">Halo, {{ auth()->user()->name }}!</h3>
            <p class="text-sm text-gray-600 mt-1">Pilih menu pengelolaan data dan verifikasi transaksi di bawah ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('admin.categories.index') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:ring-2 hover:ring-indigo-500 transition">
                <p class="text-xs font-semibold text-indigo-600 uppercase">Master Data</p>
                <h4 class="text-lg font-bold text-gray-900 mt-1">Kelola Kategori</h4>
                <p class="text-sm text-gray-600 mt-2">Tambah, ubah, dan hapus kategori paket trip.</p>
            </a>

            <a href="{{ route('admin.organizers.index') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:ring-2 hover:ring-indigo-500 transition">
                <p class="text-xs font-semibold text-indigo-600 uppercase">Master Data</p>
                <h4 class="text-lg font-bold text-gray-900 mt-1">Kelola Organizer</h4>
                <p class="text-sm text-gray-600 mt-2">Kelola data organizer dan status verifikasi.</p>
            </a>

            <a href="{{ route('admin.trips.index') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:ring-2 hover:ring-indigo-500 transition">
                <p class="text-xs font-semibold text-indigo-600 uppercase">Katalog</p>
                <h4 class="text-lg font-bold text-gray-900 mt-1">Kelola Paket Trip</h4>
                <p class="text-sm text-gray-600 mt-2">Atur paket trip, jadwal, harga, dan kuota.</p>
            </a>

            <a href="{{ route('admin.payments.index') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:ring-2 hover:ring-indigo-500 transition">
                <p class="text-xs font-semibold text-indigo-600 uppercase">Transaksi</p>
                <h4 class="text-lg font-bold text-gray-900 mt-1">Verifikasi Pembayaran</h4>
                <p class="text-sm text-gray-600 mt-2">Periksa bukti transfer dan konfirmasi booking.</p>
            </a>
        </div>
    </div>
</x-app-layout>