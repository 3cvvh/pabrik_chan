@extends('layout.main')
@section('content')
{{-- <x-navbar></x-navbar> --}}
<div class="bg-blue-100 min-h-screen py-0">
    <!-- Header -->
    <div class="bg-blue-500 py-5 px-8 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-white">Factory Owner</h1>
        <div class="flex gap-4">
            <a href="#" class="bg-white text-blue-600 font-semibold px-6 py-2 rounded-lg shadow hover:bg-blue-50 transition">Dashboard</a>
            <a href="#" class="bg-red-500 text-white font-semibold px-6 py-2 rounded-lg flex items-center gap-2 hover:bg-red-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" /></svg>
                Logout
            </a>
        </div>
    </div>
    <!-- Welcome Card -->
    <div class="flex justify-center mt-8">
        <div class="bg-white rounded-xl shadow-md p-8 w-full max-w-md text-center">
            <h2 class="text-xl font-semibold text-blue-700 mb-2">Welcome To Factory</h2>
            <p class="text-gray-600 mb-4">Terimakasih telah bergabung di Factory<br>Anda login menggunakan akun <span class="text-blue-600 font-semibold">owner</span></p>
            <a href="#" class="bg-blue-100 text-blue-700 font-semibold px-5 py-2 rounded-lg border border-blue-300 hover:bg-blue-200 transition">Dashboard Owner</a>
        </div>
    </div>
    <!-- Main Content -->
    <div class="max-w-5xl mx-auto mt-10 bg-white rounded-xl shadow-lg p-8">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Halaman Dashboard Owner</h2>
                <p class="text-gray-600 text-sm">History Data Transaksi Barang</p>
            </div>
            <button class="bg-green-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-600 transition">Cetak Generate Laporan</button>
        </div>
        <!-- Search -->
        <form class="flex items-center gap-2 mb-6">
            <input type="text" placeholder="Cari transaksi..." class="flex-1 border border-blue-400 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" />
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600 transition">Cari</button>
        </form>
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="py-2 px-3 text-left">No</th>
                        <th class="py-2 px-3 text-left">Outlet</th>
                        <th class="py-2 px-3 text-left">Tanggal</th>
                        <th class="py-2 px-3 text-left">Batas Waktu</th>
                        <th class="py-2 px-3 text-left">Pembayaran</th>
                        <th class="py-2 px-3 text-left">Tanggal Dibayar</th>
                        <th class="py-2 px-3 text-left">Customer</th>
                        <th class="py-2 px-3 text-left">Paket</th>
                        <th class="py-2 px-3 text-left">Status Order</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border-b">
                        <td class="py-2 px-3">1</td>
                        <td class="py-2 px-3">Elsa Pabrik</td>
                        <td class="py-2 px-3">2025-07-31</td>
                        <td class="py-2 px-3">2025-08-22</td>
                        <td class="py-2 px-3">Belum Dibayar</td>
                        <td class="py-2 px-3">2025-08-23</td>
                        <td class="py-2 px-3">DJ Panda</td>
                        <td class="py-2 px-3">Kain Sutra</td>
                        <td class="py-2 px-3">
                            <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Proses</span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-3">2</td>
                        <td class="py-2 px-3">Tiara Pabrik</td>
                        <td class="py-2 px-3">2025-08-02</td>
                        <td class="py-2 px-3">2025-08-25</td>
                        <td class="py-2 px-3">Dibayar</td>
                        <td class="py-2 px-3">2025-08-26</td>
                        <td class="py-2 px-3">Noel</td>
                        <td class="py-2 px-3">Kain Katun</td>
                        <td class="py-2 px-3">
                            <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Selesai</span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-3">3</td>
                        <td class="py-2 px-3">Raisya Pabrik</td>
                        <td class="py-2 px-3">2025-08-11</td>
                        <td class="py-2 px-3">2025-08-29</td>
                        <td class="py-2 px-3">Dibayar</td>
                        <td class="py-2 px-3">2025-08-30</td>
                        <td class="py-2 px-3">Blueraii</td>
                        <td class="py-2 px-3">Kain Wol</td>
                        <td class="py-2 px-3">
                            <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Proses</span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-3">4</td>
                        <td class="py-2 px-3">Tasnim Pabrik</td>
                        <td class="py-2 px-3">2025-08-24</td>
                        <td class="py-2 px-3">2025-09-03</td>
                        <td class="py-2 px-3">Dibayar</td>
                        <td class="py-2 px-3">2025-09-04</td>
                        <td class="py-2 px-3">Aqil</td>
                        <td class="py-2 px-3">Kain Linen</td>
                        <td class="py-2 px-3">
                            <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Baru</span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-3">5</td>
                        <td class="py-2 px-3">Rasya Pabrik</td>
                        <td class="py-2 px-3">2025-09-01</td>
                        <td class="py-2 px-3">2025-09-17</td>
                        <td class="py-2 px-3">Dibayar</td>
                        <td class="py-2 px-3">2025-09-18</td>
                        <td class="py-2 px-3">Tasnim</td>
                        <td class="py-2 px-3">Kain Sutra</td>
                        <td class="py-2 px-3">
                            <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Selesai</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3">6</td>
                        <td class="py-2 px-3">Aqil Pabrik</td>
                        <td class="py-2 px-3">2025-09-09</td>
                        <td class="py-2 px-3">2025-09-20</td>
                        <td class="py-2 px-3">Dibayar</td>
                        <td class="py-2 px-3">2025-09-21</td>
                        <td class="py-2 px-3">Rasya</td>
                        <td class="py-2 px-3">Kain Wol</td>
                        <td class="py-2 px-3">
                            <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Baru</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection