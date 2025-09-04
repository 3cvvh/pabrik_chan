@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
@php
    // Formatter singkat untuk IDR: 2rb, 2,5rb, 2jt, dst.
    $formatIDRShort = function($n) {
        $n = (float) ($n ?? 0);
        if ($n == 0) {
            return 'Rp 0';
        }
        $abs = abs($n);
        if ($abs >= 1000000) {
            // juta -> jt
            $val = number_format($n / 1000000, ($abs % 1000000 === 0) ? 0 : 1, ',', '');
            return 'Rp ' . $val . 'jt';
        } elseif ($abs >= 1000) {
            // ribu -> rb
            $val = number_format($n / 1000, ($abs % 1000 === 0) ? 0 : 1, ',', '');
            return 'Rp ' . $val . 'rb';
        } else {
            // kurang dari 1000 tampilkan utuh tanpa desimal
            return 'Rp ' . number_format($n, 0, ',', '.');
        }
    };
@endphp

<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Owner</h1>
            <p class="text-gray-600">Selamat datang di halaman dashboard.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-blue-500 text-4xl mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4M3 17l9 4 9-4"/>
                    </svg>
                </div>
                <div class="text-lg font-semibold text-gray-700">Gudang</div>
                <div class="text-2xl font-bold text-gray-900">{{ $gudang }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-green-500 text-4xl mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.304.534 6.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="text-lg font-semibold text-gray-700">Admin</div>
                <div class="text-2xl font-bold text-gray-900">{{ $admin }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-yellow-500 text-4xl mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"/>
                    </svg>
                </div>
                <div class="text-lg font-semibold text-gray-700">Orang Gudang</div>
                <div class="text-2xl font-bold text-gray-900">{{ $orangGudang }}</div>
            </div>
        </div>

        <!-- NEW: Total Pendapatan Bersih & Per-Produk -->
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Total Pendapatan Bersih</h2>
                        <p class="text-sm text-gray-500">Menghitung (harga_satuan - harga_modal) * jumlah, hanya transaksi selesai</p>
                    </div>
                    <div class="text-2xl font-extrabold text-green-600">
                        {{ $formatIDRShort($totalNet ?? 0) }}
                    </div>
                </div>

                <div class="mt-4">
                    <h3 class="text-md font-medium text-gray-700">Pendapatan per Produk</h3>
                    <div class="mt-3 space-y-2 max-h-56 overflow-y-auto pr-2">
                        @if(!empty($productNets) && $productNets->count() > 0)
                            @foreach($productNets as $p)
                                <div class="flex justify-between items-center bg-gray-50 rounded p-3 border">
                                    <div class="text-gray-700">{{ $p->nama }}</div>
                                    <div class="text-sm font-semibold text-gray-800">{{ $formatIDRShort($p->net ?? 0) }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-sm text-gray-500">Belum ada pendapatan tercatat.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END NEW -->

    </div>
</div>
@endsection
