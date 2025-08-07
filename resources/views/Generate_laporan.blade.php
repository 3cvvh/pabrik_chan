@extends('layout.main')
@section('content')
<div class="min-h-screen bg-blue-50 flex items-center justify-center py-10">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-10">
        <h2 class="text-center text-blue-600 text-2xl font-bold mb-2">LAPORAN TRANSAKSI BARANG PABRIK</h2>
        <hr class="border-blue-500 mb-6">

        <div class="flex justify-between mb-6">
            <div>
                <h3 class="font-semibold mb-2">Data Customer</h3>
                <div class="text-sm text-gray-700 space-y-1">
                    <div class="flex"><span class="w-40">No Transaksi</span>: <span class="ml-2">1</span></div>
                    <div class="flex"><span class="w-40">Nama Lengkap</span>: <span class="ml-2">Noel Londok</span></div>
                    <div class="flex"><span class="w-40">Alamat</span>: <span class="ml-2">Bandung</span></div>
                    <div class="flex"><span class="w-40">Jenis Kelamin</span>: <span class="ml-2">Laki-laki</span></div>
                    <div class="flex"><span class="w-40">Telepon</span>: <span class="ml-2">081912345670</span></div>
                    <div class="flex"><span class="w-40">Nama Outlet</span>: <span class="ml-2">Tiara Pabrik</span></div>
                    <div class="flex"><span class="w-40">Status Pembayaran</span>: <span class="ml-2">Dibayar</span></div>
                    <div class="flex"><span class="w-40">Status Order</span>: <span class="ml-2 font-semibold text-blue-600">Selesai</span></div>
                    <div class="flex"><span class="w-40">Tanggal Diambil</span>: <span class="ml-2">2025-08-02</span></div>
                </div>
            </div>
            <div class="text-sm text-gray-700 text-right">
                <div>Tanggal Cetak :</div>
                <div class="font-semibold">Saturday, 2025-08-02</div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="font-semibold mb-2">Detail Transaksi</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-blue-600 text-white text-sm">
                            <th class="px-3 py-2 font-semibold">No</th>
                            <th class="px-3 py-2 font-semibold">Tanggal Order</th>
                            <th class="px-3 py-2 font-semibold">Tanggal Bayar</th>
                            <th class="px-3 py-2 font-semibold">Paket Barang</th>
                            <th class="px-3 py-2 font-semibold">Berat Barang</th>
                            <th class="px-3 py-2 font-semibold">Harga/Kg</th>
                            <th class="px-3 py-2 font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        <tr>
                            <td class="px-3 py-2 border">1</td>
                            <td class="px-3 py-2 border">2025-07-10</td>
                            <td class="px-3 py-2 border">2025-08-02</td>
                            <td class="px-3 py-2 border">Kain Sutra</td>
                            <td class="px-3 py-2 border">2 Kg</td>
                            <td class="px-3 py-2 border">200,000</td>
                            <td class="px-3 py-2 border">400.000</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="px-3 py-2 border text-right font-semibold bg-blue-50">Total</td>
                            <td class="px-3 py-2 border font-bold text-blue-600 bg-blue-50">Rp. 400.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end mt-16">
            <div class="text-center">
                <div class="mb-2">Kasir Pabrik</div>
                <div class="mb-8">&nbsp;</div>
                <div>(.............................)</div>
            </div>
        </div>
    </div>
</div>
@endsection
