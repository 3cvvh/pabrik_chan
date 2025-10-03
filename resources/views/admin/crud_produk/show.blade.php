@extends('layout.main')
@section('content')

<div class="max-w-7xl mx-auto p-4 sm:p-6 space-y-8">
    <!-- Tombol Kembali -->
    <div>
        <button onclick="window.history.back()"
            class="group flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all shadow-sm border border-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-x-1"
                 viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                      clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">Kembali</span>
        </button>
    </div>

    <!-- Produk Section -->
    <section class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 p-8">
            <!-- Gambar Produk -->
            <div class="lg:col-span-6">
                <div class="rounded-2xl overflow-hidden shadow-lg bg-gray-50">
                    @if($produk->gambar)
                        <img id="mainImage" src="{{ asset('storage/' . $produk->gambar) }}"
                             alt="gambar-produk"
                             class="w-full h-[400px] object-cover transition-all duration-300">
                    @else
                        <div class="h-[400px] flex items-center justify-center bg-gray-100">
                            <span class="text-gray-400 flex flex-col items-center">
                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Tidak ada gambar</span>
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail -->
                <div class="mt-6 flex gap-4 justify-center">
                    @if($produk->gambar)
                    <button type="button"
                        class="thumbnail w-24 h-24 rounded-lg overflow-hidden border-2 border-transparent hover:border-indigo-500 focus:border-indigo-500 transition-all shadow-md hover:shadow-lg"
                        data-src="{{ asset('storage/' . $produk->gambar) }}">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="thumbnail" class="w-full h-full object-cover">
                    </button>
                    @endif
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                <div class="space-y-6">
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">{{ $produk->nama }}</h1>

                    <!-- Harga -->
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-gray-500">Harga Jual:</span>
                            <span class="text-2xl font-bold text-rose-600">Rp {{ number_format($produk->harga_jual,0,',','.') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-gray-500">Harga Modal:</span>
                            <span class="text-xl font-semibold text-gray-700">Rp {{ number_format($produk->harga_modal,0,',','.') }}</span>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="prose prose-sm max-w-none">
                        <h3 class="text-gray-600 font-medium mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $produk->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                    </div>

                    <!-- Stok -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        @php $totalStock = $stock->sum('jumlah'); @endphp
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">Total Stok:</span>
                            <span class="text-xl font-bold text-indigo-600">{{ $totalStock }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Stock Detail -->
    <section class="bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Stok</h2>

        <div class="grid gap-6">
            @forelse ($stock as $index => $item)
                <div class="border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Stock {{ $index + 1 }}</h3>
                            <p class="text-sm text-gray-600">{{ $item->gudang->nama ?? '—' }}</p>
                        </div>
                        <a href="{{ Auth::user()->role_id == 1 ? route('Stock_produk.edit',$item->id) : route('crud_stocks.edit',$item->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Stock
                        </a>
                        <div class="text-right">
                            <div class="inline-flex items-center px-3 py-1 rounded-full {{ $item->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                <span class="text-sm font-medium">{{ $item->status ?? '—' }}</span>
                            </div>
                            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $item->jumlah }} unit</p>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div class="bg-white p-3 rounded-lg">
                            <span class="block text-gray-500">Tanggal Masuk</span>
                            <span class="font-medium text-gray-900">{{ $item->tanggal_masuk ?? 'Tidak ada' }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg">
                            <span class="block text-gray-500">Tanggal Keluar</span>
                            <span class="font-medium text-gray-900">{{ $item->tanggal_keluar ?? 'Tidak ada' }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg">
                            <span class="block text-gray-500">Keterangan</span>
                            <span class="font-medium text-gray-900">{{ $item->keterangan ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="mt-4 text-gray-500">Belum ada data stok.</p>
                </div>
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
