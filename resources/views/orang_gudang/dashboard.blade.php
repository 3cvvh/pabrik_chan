@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-blue-700 mb-2">Dashboard Orang Gudang</h1>
        <p class="text-gray-600">Welcome to the Orang Gudang dashboard. Here you can manage your inventory and view reports.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center border border-blue-100">
            <h2 class="text-gray-500 font-semibold mb-1">Gudang</h2>
            <p class="text-2xl font-bold text-blue-700">{{ Auth::user()->gudang->nama }}</p>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center border border-blue-100">
            <h2 class="text-gray-500 font-semibold mb-1">Jumlah Produk</h2>
            <p class="text-2xl font-bold text-blue-700">{{ $total_produk }}</p>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center border border-blue-100">
            <h2 class="text-gray-500 font-semibold mb-1">Jumlah Orang Gudang</h2>
            <p class="text-2xl font-bold text-blue-700">{{ $org_gudang }}</p>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center border border-blue-100">
            <h2 class="text-gray-500 font-semibold mb-1">Total Stok Produk</h2>
            <p class="text-2xl font-bold text-blue-700">{{ $total_stok }}</p>
        </div>
    </div>

    <div class="mt-12">
        <h2 class="text-xl font-bold text-blue-700 mb-4 text-center">Produk Dan Stok</h2>
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-blue-600 text-white">
                         <th class="py-3 px-4 border-b">No</th>
                        <th class="py-3 px-4 border-b">Produk</th>
                        <th class="py-3 px-4 border-b">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $stok_produk as $index => $item )
                    <tr class="hover:bg-blue-50">
                        <td class="py-3 px-4 border-b text-center">{{ $index+1 }}</td>
                        <td class="py-3 px-4 border-b text-center">{{ $item->produk->nama }}</td>
                        <td class="py-3 px-4 border-b text-center">{{ $item->jumlah }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
