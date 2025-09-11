@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header Section -->
        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">Daftar produk</h1>
                <p class="text-gray-600">Kelola semua produk dalam satu tempat</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <!-- Tombol Kamera Scanner -->
                <a href="{{ Auth::user()->role_id == 1 ? route('admin.produk.scanner') : route('orang_gudang.produk.scanner') }}">
                    <button class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h2l2-3h10l2 3h2a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V9a2 2 0 012-2zm9 3a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        Kamera Scanner
                    </button>
                </a>

                @if(Auth::user()->role_id == 1)
                    <a href="{{ route('produk.create') }}">
                        <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah produk Baru
                        </button>
                    </a>
                @endif
            </div>
        </div>

        <!-- Enhanced Search/Filter Section -->
        <div class="mb-6 p-6 bg-white rounded-xl shadow-sm animate-fade-in-up" style="animation-delay: 0.1s">
            <form action="" method="get" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                    <div class="relative">
                        <input autocomplete="off" name="search" id="search" type="text"
                            value="{{ request()->get('search') }}"
                            placeholder="Cari produk..."
                            class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                    Cari
                </button>
            </form>
        </div>

        <!-- Enhanced Table Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pabrik</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga Jual</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga Modal</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">QR</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                     </thead>
                     <tbody class="bg-white divide-y divide-gray-200">
                         @foreach ($data as $index => $produk)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $data->firstItem() + $index }}</td>
                            <td class="px-6 py-4 max-w-xs truncate whitespace-nowrap text-sm font-medium text-gray-800" title="{{ $produk->nama }}">{{ $produk->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $produk->pabrik->name }}</td>
                            @if($produk->gambar)
                            <td class="px-4 py-4 whitespace-nowrap">
                                <img class="object-cover rounded-md w-20 h-20 border border-gray-100 shadow-sm" src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}">
                            </td>
                            @else
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                            @endif

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Rp {{ number_format($produk->harga_jual ?? $produk->harga ?? 0, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Rp {{ number_format($produk->harga_modal ?? 0, 0, ',', '.') }}
                                </span>
                            </td>

                           <td class="px-6 py-4 whitespace-nowrap text-center">
                               <div class="flex flex-col items-center gap-2">
                                   {!! QrCode::size(60)->generate(route('produk.show', $produk->id)) !!}
                                   <a href="{{ Auth::user()->role_id == 1 ?  route('produk.qrView', $produk) : route('produk.qrViews',$produk) }}"
                                      class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-md text-xs font-medium transition-colors duration-200">
                                       Lihat QR
                                   </a>
                               </div>
                           </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg text-sm font-medium transition-colors duration-200" href="{{ Auth::user()->role_id == 1 ? route('produk.show',$produk->id) : route('crud_produk.show',$produk->id) }}">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Details
                                    </a>
                                    @if(Auth::user()->role_id == 1)
                                    <a href="{{ Auth::user()->role_id == 1 ? route('produk.edit',$produk->id) : route('crud_produk.edit',$produk->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                       @endif
                                @if(Auth::user()->role_id == 1)
                                    <form action="{{ route('produk.destroy',$produk->id) }}" method="post" class="form">
                                        @csrf
                                        @method('delete')
                                        <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <!-- Pagination -->
        {{ $data->links('pagination::tailwind') }}
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="relative bg-white rounded-lg max-w-lg w-full p-6">
            <div class="absolute top-4 right-4">
                <button onclick="closeDetail()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detail produk</h3>
                <div id="detailContent" class="space-y-4">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(button) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

@if(session('hapus'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('hapus') }}',
        timer: 1500,
        showConfirmButton: false
    });
@endif
<x-alert></x-alert>
@if(session('edit'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('edit') }}',
        timer: 1500,
        showConfirmButton: false
    });
@endif

function showDetail(id) {
    // Fetch transaction details using AJAX
    fetch(`/dashboard/admin/crud_produk/${id}`)
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('detailContent');
            content.innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="font-medium text-gray-500">Pabrik</div>
                    <div>${data.pabrik.name}</div>
                    <div class="font-medium text-gray-500">Pembeli</div>
                    <div>${data.pembeli.name}</div>
                    <div class="font-medium text-gray-500">Jumlah</div>
                    <div>${data.jumlah}</div>
                    <div class="font-medium text-gray-500">Total Harga</div>
                    <div>Rp ${data.total_harga.toLocaleString('id-ID')}</div>
                    <div class="font-medium text-gray-500">Status</div>
                    <div>${data.status}</div>
                    <div class="font-medium text-gray-500">Tanggal</div>
                    <div>${new Date(data.created_at).toLocaleDateString('id-ID')}</div>
                </div>
            `;
            document.getElementById('detailModal').classList.remove('hidden');
        });
}

function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
}
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
}
</style>
@endsection
