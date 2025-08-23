@extends('layout.main')
@section('content')
<div class="container mx-auto px-4 py-6">
	<div class="bg-white p-6 rounded-lg shadow">
		<div class="flex justify-between items-start mb-6">
			<div>
				<h2 class="text-2xl font-bold">Laporan Transaksi</h2>
				<p class="text-sm text-gray-600">Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>
			</div>
			<div class="text-right">
				<p class="font-semibold">{{ $data_transaksi->judul ?? '—' }}</p>
				<p class="text-sm text-gray-600">Status: {{ $data_transaksi->status ?? '—' }}</p>
			</div>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-sm">
			<div>
				<p class="font-semibold mb-1">Pabrik</p>
				<p>{{ $data_transaksi->pabrik->name ?? '-' }}</p>
			</div>
			<div>
				<p class="font-semibold mb-1">Pembeli</p>
				<p>{{ $data_transaksi->pembeli->name ?? '-' }}</p>
			</div>
			<div>
				<p class="font-semibold mb-1">Tanggal Transaksi</p>
				<p>{{ $data_transaksi->tanggal_transaksi ?? '-' }}</p>
			</div>
			<div>
				<p class="font-semibold mb-1">Tanggal Pengiriman / Pembayaran</p>
				<p>{{ $data_transaksi->tanggal_pengiriman ?? '-' }} / {{ $data_transaksi->tanggal_pembayaran ?? '-' }}</p>
			</div>
		</div>

		<div class="overflow-x-auto">
			<table class="w-full border-collapse text-sm">
				<thead>
					<tr class="bg-gray-100">
						<th class="border px-3 py-2 text-left">No</th>
						<th class="border px-3 py-2 text-left">Produk</th>
						<th class="border px-3 py-2 text-right">Jumlah</th>
						<th class="border px-3 py-2 text-right">Harga Satuan</th>
						<th class="border px-3 py-2 text-right">Total</th>
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
						<tr>
							<td class="border px-3 py-2">{{ $i++ }}</td>
							<td class="border px-3 py-2">{{ $item->produk->nama ?? '—' }}</td>
							<td class="border px-3 py-2 text-right">{{ $jumlah }}</td>
							<td class="border px-3 py-2 text-right">Rp {{ number_format($harga_satuan,0,',','.') }}</td>
							<td class="border px-3 py-2 text-right">Rp {{ number_format($total,0,',','.') }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-gray-50">
						<td colspan="4" class="border px-3 py-2 text-right font-semibold">Grand Total</td>
						<td class="border px-3 py-2 text-right font-bold">Rp {{ number_format($grandTotal,0,',','.') }}</td>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="mt-6 flex justify-between items-center">
			<div class="text-sm text-gray-600">
				<p>Catatan: {{ $data_transaksi->catatan ?? '-' }}</p>
			</div>
			<div class="space-x-2">
				<button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 no-print">Print Laporan</button>
		</div>
	</div>
</div>

{{-- tambahan: sembunyikan elemen bertipe .no-print saat mencetak --}}
<style>
@media print{
	.no-print{ display:none !important; }
}
</style>

{{-- ganti skrip kondisional dengan auto-print saat halaman dimuat --}}
<script>
	window.addEventListener('load', function(){
		// delay kecil agar layout selesai dirender sebelum memanggil print
		setTimeout(function(){ window.print(); }, 300);
	});
</script>

@endsection
