@extends('layout.main')
@section('content')

<div class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-50 min-h-screen">
    <!-- Header -->
    <x-navbar></x-navbar>

    <!-- Welcome Card -->
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-lg bg-white border border-blue-200 rounded-2xl shadow-xl p-10 text-center">
            <h2 class="text-2xl font-bold text-blue-700 mb-3 tracking-wide">Welcome To Factory</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Terimakasih telah bergabung di Factory<br>
                Anda login menggunakan akun <span class="text-blue-600 font-semibold">owner</span>
            </p>
            <a href="#"
               class="px-6 py-2 font-semibold text-blue-700 bg-blue-50 border border-blue-300 rounded-lg hover:bg-blue-200 hover:shadow transition-all duration-200">
               Dashboard Owner
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto mt-12 bg-white border border-blue-100 rounded-2xl shadow-2xl p-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 mb-1">Halaman Dashboard Owner</h2>
                <p class="text-base text-gray-500">History Data Transaksi Barang</p>
            </div>
            <a href="{{ route('owner.laporanbos') }}" target="_blank"
               class="px-6 py-2 font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition">
               Generate Semua Laporan
            </a>
        </div>

        <!-- Search -->
        <form class="flex flex-col sm:flex-row items-center gap-3 mb-8">
            <input name="search" type="text" placeholder="Cari transaksi..."
                   class="flex-1 px-4 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 transition" />
            <button type="submit"
                    class="px-8 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition">
                Cari
            </button>
        </form>

        <!-- ==========================
             TABEL (desktop)
        =========================== -->
        <div class="hidden sm:block overflow-x-auto border border-gray-200 rounded-xl shadow">
            <table class="min-w-full bg-white rounded-xl">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-blue-400 text-black">
                        <th class="py-3 px-4 text-left font-semibold">No</th>
                        <th class="py-3 px-4 text-left font-semibold">Nama Transaksi</th>
                        <th class="py-3 px-4 text-left font-semibold">Customer</th>
                        <th class="py-3 px-4 text-left font-semibold">Status Order</th>
                        <th class="py-3 px-4 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($transaksi as $index => $item)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-medium">{{ $item->judul }}</td>
                            <td class="py-3 px-4">{{ $item->pembeli->name }}</td>
                            <td class="py-3 px-4">
                                <span class="px-4 py-1 text-xs font-bold border border-gray-200 rounded-full shadow-sm
                                    {{ $item->status == 'completed'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('transaksi.show',$item->id) }}"
                                   class="px-5 py-1.5 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition">
                                   Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-lg text-gray-400">
                                Tidak ada data transaksi tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ==========================
             CARD (mobile)
        =========================== -->
        <div class="sm:hidden space-y-4 mt-6">
            @forelse ($transaksi as $index => $item)
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-500">#{{ $index + 1 }}</span>
                        <span class="text-sm font-semibold {{ $item->status == 'completed' ? 'text-green-600' : 'text-amber-600' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <p class="text-base font-bold text-gray-800">{{ $item->judul }}</p>
                    <p class="text-sm text-gray-500 mb-2">Customer: {{ $item->pembeli->name }}</p>
                    <div class="flex justify-end">
                        <a href="{{ route('transaksi.show',$item->id) }}"
                           class="px-4 py-1.5 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition">
                           Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-gray-400">
                    Tidak ada data transaksi tersedia.
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
