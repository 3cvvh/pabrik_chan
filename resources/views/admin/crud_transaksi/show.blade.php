@extends('layout.main')
@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('crud_transaksi.index') }}" class="text-gray-700 hover:text-blue-600 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-gray-500 ml-1 md:ml-2 font-medium">Detail Transaksi</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Transaction Header -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="border-b border-gray-200 px-8 py-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-800">{{ $data_transaksi->judul }}</h1>
                <span class="px-4 py-2 rounded-full text-sm font-semibold inline-flex items-center
                    @if($data_transaksi->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($data_transaksi->status == 'completed') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    <span class="w-2 h-2 rounded-full mr-2
                        @if($data_transaksi->status == 'pending') bg-yellow-400
                        @elseif($data_transaksi->status == 'completed') bg-green-400
                        @else bg-gray-400
                        @endif"></span>
                    {{ $data_transaksi->status }}
                </span>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pabrik</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->pabrik->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pembeli</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->pembeli->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Tanggal Transaksi</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->tanggal_transaksi?? 'belum di kirim' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Tanggal Pengiriman</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->tanggal_pengiriman?? 'belum dikirim' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg col-span-2">
                            <p class="text-sm text-gray-500">Tanggal Pembayaran</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->tanggal_pembayaran?? 'belum dibayar' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="mt-8">
        <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            Detail Produk
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($data_detail as $data)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                @if($data->produk->gambar == null)
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @else
                    <img src="{{ asset('storage/'. $data->produk->gambar ) }}"
                         alt="{{ $data->produk->nama }}"
                         class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h4 class="font-semibold text-lg text-gray-800 mb-2">{{ $data->produk->nama }}</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600">Jumlah</p>
                            <p class="font-semibold text-lg">{{ $data->jumlah }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600">Total</p>
                            <p class="font-bold text-lg text-blue-600">Rp {{ number_format($data->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
