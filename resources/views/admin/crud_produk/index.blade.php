@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 animate-fade-in">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">Daftar Produk</h1>
                <p class="text-gray-600">Kelola semua produk dalam satu tempat</p>
            </div>
            <!-- Desktop Buttons -->
            <div class="hidden sm:flex flex-wrap gap-3 mt-4 sm:mt-0">
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
                    <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Produk Baru
                    </button>
                </a>
                @endif
            </div>
        </div>

        <!-- Mobile Buttons -->
        <div class="sm:hidden flex flex-col gap-3 mb-6">
            <a href="{{ Auth::user()->role_id == 1 ? route('admin.produk.scanner') : route('orang_gudang.produk.scanner') }}">
                <button class="w-full px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h2l2-3h10l2 3h2a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V9a2 2 0 012-2zm9 3a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    Kamera Scanner
                </button>
            </a>
            @if(Auth::user()->role_id == 1)
            <a href="{{ route('crud_stocks.create') }}">
                <button class="w-full px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Produk Baru
                </button>
            </a>
            @endif
        </div>

        <!-- Search -->
        <div class="mb-6 p-6 bg-white rounded-xl shadow-sm animate-fade-in-up" style="animation-delay: 0.1s">
            <form id="search-form" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                    <div class="relative">
                        <input autocomplete="off" name="search" id="search" type="text"
                            value="{{ request()->get('search') }}"
                            placeholder="Cari produk..."
                            class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table (Desktop) -->
        <div id="table-awal" class="hidden sm:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Pabrik</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Gambar</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Harga Jual</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Harga Modal</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">QR</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="produk" class="bg-white divide-y divide-gray-200">
                        @foreach ($data as $index => $produk)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $data->firstItem() + $index }}</td>
                            <td class="px-6 py-4 max-w-xs truncate text-sm font-medium text-gray-800" title="{{ $produk->nama }}">{{ $produk->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $produk->pabrik->name }}</td>
                            <td class="px-4 py-4">
                                @if($produk->gambar)
                                <img class="object-cover rounded-md w-20 h-20 border border-gray-100 shadow-sm" src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}">
                                @else
                                <span class="px-3 py-1 text-sm text-gray-500 bg-gray-100 rounded-full">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Rp {{ number_format($produk->harga_jual ?? $produk->harga ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Rp {{ number_format($produk->harga_modal ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    {!! QrCode::size(60)->generate(route('produk.show', $produk->id)) !!}
                                    <a href="{{ Auth::user()->role_id == 1 ?  route('produk.qrView', $produk) : route('produk.qrViews',$produk) }}"
                                        class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-md text-xs font-medium transition-colors duration-200">
                                        Lihat QR
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg text-sm font-medium transition-colors duration-200 hover:scale-105"
                                        href="{{ Auth::user()->role_id == 1 ? route('produk.show',$produk->id) : route('crud_produk.show',$produk->id) }}">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                    @if(Auth::user()->role_id == 1)
                                    <a href="{{ route('produk.edit',$produk->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('produk.destroy',$produk->id) }}" method="post" class="form" style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-colors duration-200 hover:scale-105">
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
                        @if($data->count() == 0)
                        <tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">Data tidak ditemukan</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cards (Mobile) -->
        <div id="cardsContainer" class="sm:hidden space-y-4 mt-6 animate-fade-in-up">
            @foreach($data as $index => $produk)
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition">
                <div class="flex justify-between mb-2">
                    <span class="text-xs text-gray-500">#{{ $data->firstItem() + $index }}</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">{{ $produk->pabrik->name ?? '-' }}</span>
                </div>
                <p class="text-base font-bold text-gray-800">{{ $produk->nama }}</p>
                @if($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                    class="w-full h-32 object-cover rounded-md my-2">
                @endif
                <p class="text-sm text-gray-600">
                    Harga Jual: Rp {{ number_format($produk->harga_jual ?? $produk->harga ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-500 mb-3">
                    Harga Modal: Rp {{ number_format($produk->harga_modal ?? 0, 0, ',', '.') }}
                </p>
                <div class="flex justify-center my-2">
                    {!! QrCode::size(60)->generate(route('produk.show', $produk->id)) !!}
                </div>
                <div class="flex justify-end space-x-2 mt-2">
                    <a class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg text-sm font-medium transition-colors duration-200 hover:scale-105"
                        href="{{ Auth::user()->role_id == 1 ? route('produk.show',$produk->id) : route('crud_produk.show',$produk->id) }}">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Detail
                    </a>
                    @if(Auth::user()->role_id == 1)
                    <a href="{{ route('produk.edit',$produk->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('produk.destroy',$produk->id) }}" method="post" class="form" style="display:inline;">
                        @csrf
                        @method('delete')
                        <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-colors duration-200 hover:scale-105">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
            @if($data->count() == 0)
            <div class="p-4 text-center text-gray-500">Data tidak ditemukan</div>
            @endif
        </div>
        <br>
        <div id="paginate" class="mt-4 flex justify-center animate-fade-in-up" style="animation-delay: 0.3s">
            {{ $data->links() }}
        </div>
    </div>
</div>

<style>
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
@keyframes fade-in-up { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
.animate-fade-in { animation: fade-in 0.6s ease-out forwards; }
.animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    Swal.fire({icon:'success',title:'Berhasil!',text:'{{ session('hapus') }}',timer:1500,showConfirmButton:false});
@endif
@if(session('edit'))
    Swal.fire({icon:'success',title:'Berhasil!',text:'{{ session('edit') }}',timer:1500,showConfirmButton:false});
@endif
<x-alert></x-alert>
</script>

<script>
(function () {
    const form = document.getElementById('search-form');
    const searchInput = document.getElementById('search');
    const tableContainer = document.getElementById('table-awal');
    const cardsContainer = document.getElementById('cardsContainer');
    const paginationContainer = document.getElementById('paginate');

    if (!form || !searchInput || !tableContainer || !paginationContainer) {
        return;
    }

    function debounce(fn, delay = 300) {
        let t;
        return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    function buildUrl(page) {
        const params = new URLSearchParams();
        const s = searchInput.value.trim();
        if (s.length) params.set('search', s);
        if (page) params.set('page', page);
        const base = window.location.pathname;
        const qs = params.toString();
        return qs ? `${base}?${qs}` : base;
    }

    async function fetchAndReplace(url, push = true) {
        try {
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const text = await res.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(text, 'text/html');
            const newTable = doc.getElementById('table-awal');
            const newCards = doc.getElementById('cardsContainer');
            const newPagination = doc.getElementById('paginate');

            if (newTable && tableContainer) {
                tableContainer.innerHTML = newTable.innerHTML;
            }
            if (newCards && cardsContainer) {
                cardsContainer.innerHTML = newCards.innerHTML;
            }
            if (newPagination) {
                paginationContainer.innerHTML = newPagination.innerHTML;
            }

            if (push) {
                history.pushState(null, '', url);
            }

            rebindPaginationLinks();
        } catch (err) {
            console.error('Live fetch error', err);
        }
    }

    const performSearch = debounce(() => {
        const url = buildUrl();
        fetchAndReplace(url);
    }, 350);

    searchInput.addEventListener('input', performSearch);

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const url = buildUrl();
        fetchAndReplace(url);
    });

    window.addEventListener('popstate', function () {
        fetchAndReplace(window.location.pathname + window.location.search, false);
        const qs = new URLSearchParams(window.location.search);
        searchInput.value = qs.get('search') || '';
    });

    function rebindPaginationLinks() {
        const links = paginationContainer.querySelectorAll('a');
        links.forEach(link => {
            link.replaceWith(link.cloneNode(true));
        });
        const newLinks = paginationContainer.querySelectorAll('a');
        newLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (!href) return;
                e.preventDefault();
                fetchAndReplace(href);
            });
        });
        // Rebind delete button
        document.querySelectorAll('button[onclick^="confirmDelete"]').forEach(btn => {
            btn.onclick = function() { confirmDelete(this); };
        });
    }

    rebindPaginationLinks();

})();
</script>
@endsection
