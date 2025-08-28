@extends('layout.main')
@section('content')

<div class="min-h-screen bg-blue-50 flex flex-col items-center justify-center py-15">
    <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col items-center gap-7">
        <h2 class="text-xl font-bold text-gray-700">QR Code Produk: {{ $produk->nama }}</h2>

        {{-- QR besar --}}
        {!! QrCode::size(300)->generate(route('produk.show', $produk->id)) !!}

        <div class="flex gap-4">
            {{-- Tombol download --}}
            <a href="{{ Auth::user()->role_id == 1 ? route('produk.qrDownload', $produk) : route('produk.qrDownloads',$produk) }}"
               class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-md text-xs font-medium transition-colors duration-200">
               Download QR
            </a>

            {{-- Tombol kembali --}}
            <a href="{{ Auth::user()->role_id == 1 ? route('produk.index') : route('crud_produk.index') }}"
               class="px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-gray-500 transition-all">
               Kembali
            </a>
        </div>
    </div>
</div>
@endsection
