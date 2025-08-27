@extends('layout.main')
@section('content')

<div class="min-h-screen bg-blue-50 flex flex-col items-center justify-center py-15">
    <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col items-center gap-7">
        <h2 class="text-xl font-bold text-gray-700">QR Code Produk: {{ $produk->nama }}</h2>

        {{-- QR besar --}}
        {!! QrCode::size(300)->generate(route('produk.show', $produk->id)) !!}

        <div class="flex gap-4">
            {{-- Tombol download --}}
            <a href="{{ route('produk.qrDownload', $produk) }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all">
               Download QR
            </a>

            {{-- Tombol kembali --}}
            <a href="{{ route('produk.index') }}" 
               class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-all">
               Kembali
            </a>
        </div>
    </div>
</div>
@endsection
