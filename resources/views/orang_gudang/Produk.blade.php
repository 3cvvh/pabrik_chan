@extends('layout.main')
@section('content')
<div class="min-h-screen bg-blue-50">
        <x-navbar></x-navbar>
  
    <div class="flex flex-col items-center mt-10">
        <form class="w-full max-w-xl mb-8">
            <div class="flex">
                <input type="text" placeholder="Cari Produk..." class="flex-1 px-4 py-3 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-r-lg font-semibold">Cari</button>
            </div>
        </form>
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl p-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-blue-600 text-lg font-bold">Data Produk</h2>
                <span class="text-blue-600 text-2xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A2 2 0 0021 6.382V5a2 2 0 00-2-2H5a2 2 0 00-2 2v1.382a2 2 0 001.447 1.342L9 10m6 0v10a2 2 0 01-2 2H7a2 2 0 01-2-2V10m6 0l-6-3"/></svg></span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="px-4 py-2 font-semibold">No</th>
                            <th class="px-4 py-2 font-semibold">Nama Produk</th>
                            <th class="px-4 py-2 font-semibold">Deskripsi Produk</th>
                            <th class="px-4 py-2 font-semibold">Jumlah Stok</th>
                            <th class="px-4 py-2 font-semibold">QR Status</th>
                            <th class="px-4 py-2 font-semibold"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm4 4h8v8H8V8z"/></svg></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr class="border-b">
                            <td class="px-4 py-2">1</td>
                            <td class="px-4 py-2">Kain Sutra Premium</td>
                            <td class="px-4 py-2">Kain sutra kualitas tinggi dengan kilau alami, cocok untuk busana formal.</td>
                            <td class="px-4 py-2">120 roll</td>
                            <td class="px-4 py-2">Terscan</td>
                            <td class="px-4 py-2"><img src="https://api.qrserver.com/v1/create-qr-code/?size=40x40&data=1" alt="QR"></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2">2</td>
                            <td class="px-4 py-2">Kain Katun Lokal</td>
                            <td class="px-4 py-2">Kain katun nyaman untuk pakaian sehari-hari, ringan dan menyerap keringat.</td>
                            <td class="px-4 py-2">300 roll</td>
                            <td class="px-4 py-2">Belum Scan</td>
                            <td class="px-4 py-2"><img src="https://api.qrserver.com/v1/create-qr-code/?size=40x40&data=2" alt="QR"></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2">3</td>
                            <td class="px-4 py-2">Kain Wol Halus</td>
                            <td class="px-4 py-2">Bahan wol lembut, ideal untuk pakaian musim dingin atau jas.</td>
                            <td class="px-4 py-2">75 roll</td>
                            <td class="px-4 py-2">Terscan</td>
                            <td class="px-4 py-2"><img src="https://api.qrserver.com/v1/create-qr-code/?size=40x40&data=3" alt="QR"></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2">4</td>
                            <td class="px-4 py-2">Kain Linen Impor</td>
                            <td class="px-4 py-2">Tekstur kain linen alami, cocok untuk busana musim panas.</td>
                            <td class="px-4 py-2">180 roll</td>
                            <td class="px-4 py-2">Belum Scan</td>
                            <td class="px-4 py-2"><img src="https://api.qrserver.com/v1/create-qr-code/?size=40x40&data=4" alt="QR"></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2">5</td>
                            <td class="px-4 py-2">Kain Drill Tebal</td>
                            <td class="px-4 py-2">Bahan kain kuat dan tidak mudah robek, cocok untuk seragam kerja.</td>
                            <td class="px-4 py-2">120 roll</td>
                            <td class="px-4 py-2">Terscan</td>
                            <td class="px-4 py-2"><img src="https://api.qrserver.com/v1/create-qr-code/?size=40x40&data=5" alt="QR"></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">6</td>
                            <td class="px-4 py-2">Kain Denim Klasik</td>
                            <td class="px-4 py-2">Klasik denim cocok untuk jeans atau jaket.</td>
                            <td class="px-4 py-2">150 roll</td>
                            <td class="px-4 py-2">Terscan</td>
                            <td class="px-4 py-2"><img src="https://api.qrserver.com/v1/create-qr-code/?size=40x40&data=6" alt="QR"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
