@extends('layout.main')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Laporan Transaksi</h2>
                <p class="text-sm text-gray-600 mt-1 md:mt-2">Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>
            </div>
            <div class="text-left md:text-right">
                <p class="font-semibold text-base md:text-lg text-gray-800">{{ $data_transaksi->judul ?? '—' }}</p>
                <span class="inline-flex items-center px-2 md:px-3 py-1 rounded-full text-xs md:text-sm font-medium {{ $data_transaksi->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} mt-2">
                    Status: {{ $data_transaksi->status ?? '—' }}
                </span>
            </div>
        </div>

        <!-- Detail transaksi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8">
            <div class="bg-gray-50 p-3 md:p-4 rounded-lg">
                <p class="font-semibold text-gray-700 mb-1">Pabrik</p>
                <p class="text-gray-800 text-sm md:text-base">{{ $data_transaksi->pabrik->name ?? '-' }}</p>
            </div>
            <div class="bg-gray-50 p-3 md:p-4 rounded-lg">
                <p class="font-semibold text-gray-700 mb-1">Pembeli</p>
                <p class="text-gray-800 text-sm md:text-base">{{ $data_transaksi->pembeli->name ?? '-' }}</p>
            </div>
            <div class="bg-gray-50 p-3 md:p-4 rounded-lg">
                <p class="font-semibold text-gray-700 mb-1">Tanggal Transaksi</p>
                <p class="text-gray-800 text-sm md:text-base">{{ $data_transaksi->tanggal_transaksi ?? '-' }}</p>
            </div>
            <div class="bg-gray-50 p-3 md:p-4 rounded-lg">
                <p class="font-semibold text-gray-700 mb-1">Tanggal Pengiriman / Pembayaran</p>
                <p class="text-gray-800 text-sm md:text-base">{{ $data_transaksi->tanggal_pengiriman ?? '-' }} / {{ $data_transaksi->tanggal_pembayaran ?? '-' }}</p>
            </div>
        </div>

        <!-- Tabel produk -->
        <div class="overflow-x-auto bg-gray-50 rounded-lg p-3 md:p-4">
            <table class="w-full border-collapse text-xs sm:text-sm md:text-base">
                <thead>
                    <tr>
                        <th class="bg-gray-100 border-b-2 border-gray-300 px-2 md:px-4 py-2 md:py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="bg-gray-100 border-b-2 border-gray-300 px-2 md:px-4 py-2 md:py-3 text-left font-semibold text-gray-700">Produk</th>
                        <th class="bg-gray-100 border-b-2 border-gray-300 px-2 md:px-4 py-2 md:py-3 text-right font-semibold text-gray-700">Jumlah</th>
                        <th class="bg-gray-100 border-b-2 border-gray-300 px-2 md:px-4 py-2 md:py-3 text-right font-semibold text-gray-700">Harga Satuan</th>
                        <th class="bg-gray-100 border-b-2 border-gray-300 px-2 md:px-4 py-2 md:py-3 text-right font-semibold text-gray-700">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; $i = 1; @endphp
                    @foreach($data_detail as $item)
                        @php
                            $jumlah = (int) $item->jumlah;
                            $total = (float) $item->total_harga;
                            $harga_satuan = ($jumlah > 0) ? ($total / $jumlah) : 0;
                            $grandTotal += $total;
                        @endphp
                        <tr class="hover:bg-gray-100">
                            <td class="border-b border-gray-200 px-2 md:px-4 py-2 md:py-3">{{ $i++ }}</td>
                            <td class="border-b border-gray-200 px-2 md:px-4 py-2 md:py-3">{{ $item->produk->nama ?? '—' }}</td>
                            <td class="border-b border-gray-200 px-2 md:px-4 py-2 md:py-3 text-right">{{ number_format($jumlah, 0, ',', '.') }}</td>
                            <td class="border-b border-gray-200 px-2 md:px-4 py-2 md:py-3 text-right">Rp {{ number_format($harga_satuan,0,',','.') }}</td>
                            <td class="border-b border-gray-200 px-2 md:px-4 py-2 md:py-3 text-right">Rp {{ number_format($total,0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="px-2 md:px-4 py-2 md:py-3 text-right font-semibold text-gray-700">Grand Total</td>
                        <td class="px-2 md:px-4 py-2 md:py-3 text-right font-bold text-gray-800 bg-gray-200">Rp {{ number_format($grandTotal,0,',','.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Catatan & Tombol -->
        <div class="mt-6 md:mt-8 flex flex-col md:flex-row justify-between items-stretch gap-4">
            <div class="bg-gray-50 p-3 md:p-4 rounded-lg flex-grow">
                <p class="font-semibold text-gray-700 mb-1 md:mb-2">Catatan:</p>
                <p class="text-gray-800 text-sm md:text-base">{{ $data_transaksi->catatan ?? '-' }}</p>
            </div>
            <button onclick="window.print()" class="px-4 md:px-6 py-2 md:py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 no-print flex items-center justify-center text-sm md:text-base">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Laporan
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    @page { margin: 0.5cm; }
    body { padding: 1cm; }
    .no-print { display: none !important; }
    .container { max-width: none !important; }
    .shadow-lg { box-shadow: none !important; }
}
</style>

<script>
window.addEventListener('load', function(){
    setTimeout(function(){ window.print(); }, 500);
});
<x-alert></x-alert>
</script>
@endsection
