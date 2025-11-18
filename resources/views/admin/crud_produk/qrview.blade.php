@extends('layout.main')
@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-lg md:max-w-2xl p-6 md:p-8 rounded-2xl shadow-2xl flex flex-col items-center gap-6 animate-fadeIn">

        <!-- Judul -->
        <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 text-center">
            QR Code Produk: <span class="text-indigo-600">{{ $produk->nama }}</span>
            <p><a href="{{ route('produk.show',$produk->id) }}">click</a></p>
        </h2>

        <!-- QR besar -->
        <div class="w-full flex justify-center">
            <div class="p-2 bg-gray-50 rounded-xl shadow-inner">
                {!! QrCode::format('svg')->size(300)->generate(route('produk.show', $produk->id)) !!}
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex flex-col sm:flex-row gap-3 w-full justify-center">
            {{-- Tombol download --}}
            <a href="{{ Auth::user()->role_id == 1 ? route('produk.qrDownload', $produk) : route('produk.qrDownloads',$produk) }}"
               class="inline-flex justify-center items-center px-4 py-2 bg-indigo-500 text-black hover:bg-indigo-600 rounded-lg text-sm sm:text-base font-medium transition duration-200 shadow">
                Download QR
            </a>

            {{-- Tombol kembali --}}
            <a href="{{ Auth::user()->role_id == 1 ? route('produk.index') : route('crud_produk.index') }}"
               class="inline-flex justify-center items-center px-4 py-2 bg-blue-400 text-white hover:bg-blue-500 rounded-lg text-sm sm:text-base font-medium transition duration-200 shadow">
                Kembali
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.6s ease-out forwards;
    }
</style>
@endsection
