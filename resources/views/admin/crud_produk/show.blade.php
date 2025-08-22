@extends('layout.main')
@section('content')

<div class="max-w-6xl mx-auto p-6">
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <button onclick="window.history.back()" class="flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </button>
    </div>

	<section class="bg-white shadow rounded-lg overflow-hidden">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 p-6">
			<!-- Galeri -->
			<div class="lg:col-span-6">
				<div class="rounded-lg overflow-hidden">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="gambar-produk" class="w-full h-96 object-cover rounded">
                    @else
				<h1>tidak ada gambar</h1>
                    @endif
				</div>

				<div class="mt-4 flex gap-3">
					<!-- Thumbnail utama (produk.gambar) -->
					<button type="button" class="thumbnail w-20 h-20 rounded overflow-hidden border-2 border-transparent focus:border-blue-500" data-src="{{ asset('storage/' . $produk->gambar) }}">
					</button>
				</div>
			</div>

			<!-- Detail -->
			<div class="lg:col-span-6 flex flex-col justify-between">
				<div>
					<h1 class="text-2xl font-bold">{{ $produk->nama }}</h1>

					<div class="mt-4 flex items-center gap-4">
						<div class="text-2xl font-extrabold text-rose-600">Rp {{ number_format($produk->harga,0,',','.') }}</div>
					</div>

					<div class="mt-4 text-sm text-gray-700">
						<p>{{ $produk->deskripsi }}</p>
					</div>

					<div class="mt-6 flex items-center gap-4">
						<!-- Quantity -->
						@php $totalStock = $stock->sum('jumlah'); @endphp

						<!-- Stock -->
						<div class="text-sm text-gray-600">Total stok: <span id="stock" class="font-semibold">{{ $totalStock }}</span></div>
					</div>
	</section>

	<!-- Daftar stock detail -->
	<section class="mt-6 bg-white shadow rounded-lg p-6">
		<h2 class="text-lg font-semibold mb-4">Detail Stok</h2>

		@foreach ($stock as $index => $item)
			<div class="mb-4 border rounded p-4">
				<div class="flex justify-between items-start">
					<div>
						<h3 class="font-semibold">Stock {{ $index + 1 }}</h3>
						<p class="text-sm text-gray-600">{{ $item->gudang->nama ?? '—' }}</p>
					</div>
                    <div>
                        <a href="{{ route('Stock_produk.edit',$item->id) }}">edit stock</a>
                    </div>
					<div class="text-right">
						<p class="text-sm text-gray-600">Status: <span class="font-medium">{{ $item->status ?? '—' }}</span></p>
						<p class="text-sm text-gray-600">Jumlah: <span class="font-medium">{{ $item->jumlah }}</span></p>
					</div>
				</div>

				<div class="mt-3 text-sm text-gray-700">
					<p>tanggal_masuk: {{ $item->tanggal_masuk ?? 'Tidak ada' }}</p>
					<p>tanggal_keluar: {{ $item->tanggal_keluar ?? 'Tidak ada' }}</p>
					<p>keterangan: {{ $item->keterangan ?? '-' }}</p>
				</div>
			</div>
		@endforeach
	</section>
</div>

<!-- Skrip kecil untuk interaksi -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		// Ganti gambar utama saat klik thumbnail
		document.querySelectorAll('.thumbnail').forEach(btn => {
			btn.addEventListener('click', () => {
				const src = btn.getAttribute('data-src');
				document.getElementById('mainImage').src = src;
				document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('ring-2','ring-blue-500'));
				btn.classList.add('ring-2','ring-blue-500');
			});
		});

		// Kontrol kuantitas sederhana
		const qtyInput = document.getElementById('qty');
		const formQty = document.getElementById('formQty');
		const stockEl = document.getElementById('stock');
		const stock = parseInt(stockEl.textContent || '0', 10);

		document.getElementById('incr').addEventListener('click', () => {
			let v = parseInt(qtyInput.value||'1',10);
			if (v < stock) qtyInput.value = v + 1;
			formQty.value = qtyInput.value;
		});
		document.getElementById('decr').addEventListener('click', () => {
			let v = parseInt(qtyInput.value||'1',10);
			if (v > 1) qtyInput.value = v - 1;
			formQty.value = qtyInput.value;
		});
		qtyInput.addEventListener('change', () => {
			let v = parseInt(qtyInput.value||'1',10);
			if (v < 1) v = 1;
			if (v > stock) v = stock;
			qtyInput.value = v;
			formQty.value = v;
		});

		// Tombol aksi (placeholder)
		document.getElementById('buyNow').addEventListener('click', () => {
			alert('Proses pembelian (demo).');
		});
	});
</script>

@endsection
