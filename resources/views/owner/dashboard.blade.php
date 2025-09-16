{{-- ...existing code... --}}
@extends('layout.main')
@section('content')
{{-- <x-navbar></x-navbar> --}}
<div class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-50 min-h-screen py-0">
    <!-- Header -->
    <x-navbar></x-navbar>
    <!-- Welcome Card -->
    <div class="flex justify-center mt-10">
        <div class="bg-white rou    nded-2xl shadow-xl p-10 w-full max-w-lg text-center border border-blue-200">
            <h2 class="text-2xl font-bold text-blue-700 mb-3 tracking-wide">Welcome To Factory</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">Terimakasih telah bergabung di Factory<br>Anda login menggunakan akun <span class="text-blue-600 font-semibold">owner</span></p>
            <a href="#" class="bg-blue-50 text-blue-700 font-semibold px-6 py-2 rounded-lg border border-blue-300 hover:bg-blue-200 hover:shadow transition-all duration-200">Dashboard Owner</a>

        </div>
    </div>


    <!-- Main Content -->
    <div class="max-w-5xl mx-auto mt-12 bg-white rounded-2xl shadow-2xl p-10 border border-blue-100">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 mb-1">Halaman Dashboard Owner</h2>
                <p class="text-gray-500 text-base">History Data Transaksi Barang</p>
            </div>
            <div>
                <a href="{{ route("owner.laporanbos") }}" target="_blank" class="bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-blue-600 transition">Generate Semua Laporan</a>
            </div>
        </div>
        {{-- ...existing code... --}}
        <form class="flex flex-col sm:flex-row items-center gap-3 mb-8">
            <input name="search" type="text" placeholder="Cari transaksi..." class="flex-1 border border-blue-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-sm transition" />
            <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-lg font-semibold hover:bg-blue-700 shadow transition">Cari</button>
        </form>
        {{-- ...existing code... --}}
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow">
            <table class="min-w-full bg-white rounded-xl">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-blue-400 text-white">
                        <th class="py-3 px-4 text-left font-semibold">No</th>
                        <th class="py-3 px-4 text-left font-semibold">Nama Transaksi</th>
                        <th class="py-3 px-4 text-left font-semibold">Customer</th>
                        <th class="py-3 px-4 text-left font-semibold">Status Order</th>
                        <th class="py-3 px-4 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($data as $index => $transaksi)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="py-3 px-4">{{ $data->firstItem() + $index }}</td>
                        <td class="py-3 px-4 font-medium">{{ $transaksi->judul }}</td>
                        <td class="py-3 px-4">{{ $transaksi->pembeli->name }}</td>
                        <td class="py-3 px-4">
                            <span class="{{ $transaksi->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'  }} px-4 py-1 rounded-full text-xs font-bold border border-gray-200 shadow-sm">
                                {{ ucfirst($transaksi->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('transaksi.show',$transaksi->id) }}" class="bg-blue-500 text-white px-5 py-1.5 rounded-lg text-sm font-semibold hover:bg-blue-600 shadow transition">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-400 text-lg">
                            Tidak ada data transaksi tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
                {{-- pagination --}}
        {{ $data->links('pagination::tailwind') }}
    </div>
</div>
@endsection
{{-- ...existing code... --}}
