{{-- ...existing code... --}}
@extends('layout.main')
@section('content')
{{-- <x-navbar></x-navbar> --}}
<div class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-50 min-h-screen py-0">
    <!-- Header -->
    <x-navbar></x-navbar>
    <!-- Welcome Card -->
    <div class="flex justify-center mt-10">
        <div class="bg-white rounded-2xl shadow-xl p-10 w-full max-w-lg text-center border border-blue-200">
            <h2 class="text-2xl font-bold text-blue-700 mb-3 tracking-wide">Welcome To Factory</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">Terimakasih telah bergabung di Factory<br>Anda login menggunakan akun <span class="text-blue-600 font-semibold">owner</span></p>
            <a href="#" class="bg-blue-50 text-blue-700 font-semibold px-6 py-2 rounded-lg border border-blue-300 hover:bg-blue-200 hover:shadow transition-all duration-200">Dashboard Owner</a>

        </div>
    </div>

    <!-- NEW: Pendapatan Bersih summary -->
    <div class="max-w-5xl mx-auto mt-6 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-3">
                <div class="bg-white rounded-2xl shadow p-6 border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Total Pendapatan Bersih</h3>
                            <p class="text-sm text-gray-500">Dari semua produk (filter: transaksi selesai)</p>
                        </div>
                        <div class="text-2xl font-extrabold text-green-600">
                            Rp {{ number_format($totalNet ?? 0,2,',','.') }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="font-medium text-gray-700">Per Produk</h4>
                        <div class="mt-3 space-y-2 max-h-48 overflow-y-auto pr-2">
                            @if(!empty($productNets) && $productNets->count() > 0)
                                @foreach($productNets as $p)
                                    <div class="flex justify-between items-center bg-gray-50 rounded p-3 border">
                                        <div class="text-gray-700">{{ $p->nama }}</div>
                                        <div class="text-sm font-semibold text-gray-800">Rp {{ number_format($p->net ?? 0,2,',','.') }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-sm text-gray-500">Belum ada pendapatan tercatat.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END NEW -->

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto mt-12 bg-white rounded-2xl shadow-2xl p-10 border border-blue-100">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 mb-1">Halaman Dashboard Owner</h2>
                <p class="text-gray-500 text-base">History Data Transaksi Barang</p>
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
                    @forelse ($transaksi as $index => $transaksi)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="py-3 px-4">{{ $index+1 }}</td>
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
    </div>
</div>
@endsection
{{-- ...existing code... --}}
