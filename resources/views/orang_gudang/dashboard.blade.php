@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-blue-700 mb-2">Dashboard Orang Gudang</h1>
        <p class="text-gray-600">Welcome to the Orang Gudang dashboard. Here you can manage your inventory and view reports.</p>
    </div>

    <div class="flex flex-wrap gap-6 mb-10">
        <div class="bg-white shadow rounded-lg p-6 flex-1 min-w-[200px]">
            <h3 class="text-sm font-semibold text-gray-500 mb-2">Jumlah User</h3>
            <p class="text-2xl font-bold text-blue-700">14</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 flex-1 min-w-[200px]">
            <h3 class="text-sm font-semibold text-gray-500 mb-2">Jumlah Transaksi</h3>
            <p class="text-2xl font-bold text-blue-700">8</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 flex-1 min-w-[200px]">
            <h3 class="text-sm font-semibold text-gray-500 mb-2">Jumlah Pelanggan</h3>
            <p class="text-2xl font-bold text-blue-700">6</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 flex-1 min-w-[200px]">
            <h3 class="text-sm font-semibold text-gray-500 mb-2">Jumlah Outlet</h3>
            <p class="text-2xl font-bold text-blue-700">5</p>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-8">
        <h3 class="text-xl font-semibold text-blue-700 mb-6">Data Transaksi Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 bg-blue-700 text-white text-left text-sm font-semibold">No</th>
                        <th class="px-4 py-2 bg-blue-700 text-white text-left text-sm font-semibold">Outlet</th>
                        <th class="px-4 py-2 bg-blue-700 text-white text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-4 py-2 bg-blue-700 text-white text-left text-sm font-semibold">Batas Waktu</th>
                        <th class="px-4 py-2 bg-blue-700 text-white text-left text-sm font-semibold">Pembayaran</th>
                        <th class="px-4 py-2 bg-blue-700 text-white text-left text-sm font-semibold">Tanggal Dibayar</th>
                        <th class="px-4 py-2 bg-blue-700 text-white text-left text-sm font-semibold">Customer</th>
                        <th class="px-4 py-2 bg-blue-700 text-white text-left text-sm font-semibold">Paket</th>
                        <th class="px-4 py-2 bg-blue-700 text-white text-left text-sm font-semibold">Status Order</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-4 py-2">1</td>
                        <td class="px-4 py-2">Rasya Pabrik</td>
                        <td class="px-4 py-2">2025-07-31</td>
                        <td class="px-4 py-2">2025-08-22</td>
                        <td class="px-4 py-2">Dibayar</td>
                        <td class="px-4 py-2">2025-08-23</td>
                        <td class="px-4 py-2">Tasnim</td>
                        <td class="px-4 py-2">Kain Katun</td>
                        <td class="px-4 py-2"><span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">Proses</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">2</td>
                        <td class="px-4 py-2">Tiara Pabrik</td>
                        <td class="px-4 py-2">2025-08-07</td>
                        <td class="px-4 py-2">2025-08-27</td>
                        <td class="px-4 py-2">Belum Dibayar</td>
                        <td class="px-4 py-2">2025-08-28</td>
                        <td class="px-4 py-2">Noel</td>
                        <td class="px-4 py-2">Kain Linen</td>
                        <td class="px-4 py-2"><span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Selesai</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">3</td>
                        <td class="px-4 py-2">Elsa Pabrik</td>
                        <td class="px-4 py-2">2025-08-15</td>
                        <td class="px-4 py-2">2025-09-10</td>
                        <td class="px-4 py-2">Dibayar</td>
                        <td class="px-4 py-2">2025-09-11</td>
                        <td class="px-4 py-2">DJ Panda</td>
                        <td class="px-4 py-2">Kain Wol</td>
                        <td class="px-4 py-2"><span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">Proses</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">4</td>
                        <td class="px-4 py-2">Aqil Pabrik</td>
                        <td class="px-4 py-2">2025-08-29</td>
                        <td class="px-4 py-2">2025-09-17</td>
                        <td class="px-4 py-2">Dibayar</td>
                        <td class="px-4 py-2">2025-09-18</td>
                        <td class="px-4 py-2">Rasya</td>
                        <td class="px-4 py-2">Kain Sutra</td>
                        <td class="px-4 py-2"><span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Baru</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">5</td>
                        <td class="px-4 py-2">Raisya Pabrik</td>
                        <td class="px-4 py-2">2025-09-08</td>
                        <td class="px-4 py-2">2025-09-21</td>
                        <td class="px-4 py-2">Belum Dibayar</td>
                        <td class="px-4 py-2">2025-09-22</td>
                        <td class="px-4 py-2">Blueraii</td>
                        <td class="px-4 py-2">Kain Linen</td>
                        <td class="px-4 py-2"><span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Selesai</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">6</td>
                        <td class="px-4 py-2">Tasnim Pabrik</td>
                        <td class="px-4 py-2">2025-09-14</td>
                        <td class="px-4 py-2">2025-09-28</td>
                        <td class="px-4 py-2">Dibayar</td>
                        <td class="px-4 py-2">2025-09-29</td>
                        <td class="px-4 py-2">Aqil</td>
                        <td class="px-4 py-2">Kain Wol</td>
                        <td class="px-4 py-2"><span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Baru</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection