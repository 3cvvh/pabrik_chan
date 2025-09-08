@extends('layout.main')
@section('content')

<div class="max-w-7xl mx-auto p-4 sm:p-6">
    <!-- Tombol Kembali -->
    <div class="mb-6">
        <button onclick="window.history.back()" 
            class="flex items-center gap-2 px-4 py-2 bg-gray-700 text-black rounded-lg hover:bg-gray-800 transition-all shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" 
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" 
                    clip-rule="evenodd" />
            </svg>
            <span>Kembali</span>
        </button>
    </div>

    <!-- Produk Section -->
    <section class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 p-6">
            
            <!-- Gambar Produk -->
            <div class="lg:col-span-6 flex flex-col items-center">
                <div class="w-full rounded-xl overflow-hidden shadow">
                    @if($produk->gambar)
                        <img id="mainImage" src="{{ asset('storage/' . $produk->gambar) }}" 
                             alt="gambar-produk" 
                             class="w-full h-80 sm:h-96 object-cover">
                    @else
                        <div class="h-80 sm:h-96 flex items-center justify-center bg-gray-100 text-gray-500 text-sm">
                            Tidak ada gambar
                        </div>
                    @endif
                </div>

                <!-- Thumbnail -->
                <div class="mt-4 flex gap-3">
                    @if($produk->gambar)
                    <button type="button" 
                        class="thumbnail w-20 h-20 rounded overflow-hidden border-2 border-transparent focus:border-indigo-500 transition-all"
                        data-src="{{ asset('storage/' . $produk->gambar) }}">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="thumbnail" class="w-full h-full object-cover">
                    </button>
                    @endif
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="lg:col-span-6 flex flex-col justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800">{{ $produk->nama }}</h1>

                    <!-- Harga -->
                    <div class="mt-4 text-2xl font-bold text-rose-600">
                        Rp {{ number_format($produk->harga,0,',','.') }}
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-4 text-sm sm:text-base text-gray-700 leading-relaxed">
                        <p>{{ $produk->deskripsi }}</p>
                    </div>

                    <!-- Stok -->
                    <div class="mt-6 text-sm sm:text-base text-gray-700">
                        @php $totalStock = $stock->sum('jumlah'); @endphp
                        Total stok: <span id="stock" class="font-semibold">{{ $totalStock }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Stock Detail -->
    <section class="mt-8 bg-white shadow-lg rounded-xl p-6">
        <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-800">Detail Stok</h2>

        <div class="grid gap-4">
            @forelse ($stock as $index => $item)
                <div class="border rounded-lg p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-800">Stock {{ $index + 1 }}</h3>
                            <p class="text-sm text-gray-600">{{ $item->gudang->nama ?? '—' }}</p>
                        </div>
                        <div class="text-sm text-indigo-600 hover:underline">
                            <a href="{{ Auth::user()->role_id == 1 ? route('Stock_produk.edit',$item->id) : route('crud_stocks.edit',$item->id) }}">
                                Edit Stock
                            </a>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Status: <span class="font-medium">{{ $item->status ?? '—' }}</span></p>
                            <p class="text-sm text-gray-600">Jumlah: <span class="font-medium">{{ $item->jumlah }}</span></p>
                        </div>
                    </div>

                    <div class="mt-3 text-sm text-gray-700 grid gap-1">
                        <p><span class="font-medium">Tanggal Masuk:</span> {{ $item->tanggal_masuk ?? 'Tidak ada' }}</p>
                        <p><span class="font-medium">Tanggal Keluar:</span> {{ $item->tanggal_keluar ?? 'Tidak ada' }}</p>
                        <p><span class="font-medium">Keterangan:</span> {{ $item->keterangan ?? '-' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Belum ada data stok.</p>
            @endforelse
        </div>
    </section>
</div>

<!-- Skrip interaksi thumbnail -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.thumbnail').forEach(btn => {
			btn.addEventListener('click', () => {
				const src = btn.getAttribute('data-src');
				document.getElementById('mainImage').src = src;

				document.querySelectorAll('.thumbnail')
					.forEach(t => t.classList.remove('ring-2','ring-indigo-500'));
				btn.classList.add('ring-2','ring-indigo-500');
			});
		});
	});
</script>

@endsection
