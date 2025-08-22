@extends('layout.main')
@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Breadcrumb -->
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('produk.index') }}" class="text-gray-700 hover:text-blue-600">
                    <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="flex items-center">
                <span class="mx-2">/</span>
                <span class="text-gray-500">Detail Produk</span>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
        @if($stock == null)
        @foreach ($stock as $index => $stock)
        <div class="grid md:grid-cols-2 gap-0">
            <!-- Product Image Section -->
            <div class="relative group overflow-hidden cursor-pointer" onclick="openModal()">
                <img src="{{ asset('storage/' . $stock->produk->gambar) }}"
                     alt="{{ $stock->produk->nama }}"
                     class="w-full h-[600px] object-cover transform group-hover:scale-110 transition duration-700 ease-in-out"
                     id="productImage">
                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div class="bg-white/90 rounded-full p-3 transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-8">
                    <h1 class="text-white text-4xl font-bold mb-2">{{ $stock->produk->nama }}</h1>
                    <p class="text-white/90 text-xl font-semibold">Rp {{ number_format($stock->produk->harga, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Product Information -->
            <div class="p-8 bg-white">
                <div class="space-y-6">
                    <!-- Stock Status Badge -->
                    <div class="inline-flex items-center">
                        <span class="px-3 py-1 text-sm rounded-full {{ $stock->jumlah > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $stock->jumlah > 0 ? 'Tersedia' : 'Stok Habis' }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                            <span class="text-gray-600">Stok Tersedia</span>
                            <span class="font-semibold text-gray-800">{{ $stock->jumlah }} unit</span>
                        </div>

                        <div class="pb-4">
                            <h3 class="text-gray-600 mb-2">Deskripsi Produk</h3>
                            <p class="text-gray-800 leading-relaxed">{{ $stock->produk->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                        </div>

                        <!-- Product Metadata -->
                        <div class="grid grid-cols-2 gap-4 py-4 border-t border-gray-200">
                            <div>
                                <span class="text-gray-500 text-sm">Terakhir Diupdate</span>
                                <p class="text-gray-800">{{ $stock->updated_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-sm">ID Produk</span>
                                <p class="text-gray-800">#{{ $stock->id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-6">
                        <a href="{{ route('produk.edit', $stock->id) }}"
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 text-center font-semibold">
                            Edit Produk
                        </a>
                        <a href="{{ route('produk.index') }}"
                           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg transition duration-200 text-center font-semibold">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <h1>data stock belum ada</h1>
        @endif
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/90 flex items-center justify-center cursor-zoom-out" onclick="closeModal()">
        <div class="relative max-w-4xl max-h-[90vh] mx-auto">
            <img id="modalImage" src="" alt="Product Image Large"
                 class="max-w-full max-h-[90vh] object-contain">
            <button class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors duration-200"
                    onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Add this script section at the end of your content -->
    <script>
        function openModal() {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const productImg = document.getElementById('productImage');

            modalImg.src = productImg.src;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</div>
@endsection
