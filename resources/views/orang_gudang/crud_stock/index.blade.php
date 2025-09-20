@extends('layout.main') 
@section('content')
<x-navbar></x-navbar>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header Section -->
        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">Daftar Stok</h1>
                <p class="text-gray-600">Kelola semua stok dalam satu tempat</p>
            </div>
           <a href="{{ route('crud_stocks.create') }}"
            class="px-3 py-1.5 text-sm gap-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 shadow flex items-center
                    sm:px-5 sm:py-2.5 sm:text-base sm:gap-2">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Stok Baru
            </a>
        </div>

        <!-- Enhanced Search/Filter Section -->
        <div class="mb-6 p-6 bg-white rounded-xl shadow-sm animate-fade-in-up" style="animation-delay: 0.1s">
            <form id="form-s" action="" method="get" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Stok</label>
                    <div class="relative">
                        <input autocomplete="off" name="search" id="search" type="text"
                            value="{{ request()->get('search') }}"
                            placeholder="Cari stok..."
                            class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- NEW: Produk filter -->
                <div class="min-w-[200px]">
                    <label for="produk" class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                    <select name="produk" id="produk" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                        <option value="">Semua Produk</option>
                        @if(isset($produks))
                            @foreach($produks as $p)
                                <option value="{{ $p->id }}" {{ (string)request()->get('produk') === (string)$p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- NEW: Gudang filter -->
                <div class="min-w-[200px]">
                    <label for="gudang" class="block text-sm font-medium text-gray-700 mb-1">Gudang</label>
                    <select name="gudang" id="gudang" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                        <option value="">Semua Gudang</option>
                        @if(isset($gudang))
                            @foreach($gudang as $g)
                                <option value="{{ $g->id }}" {{ (string)request()->get('gudang') === (string)$g->id ? 'selected' : '' }}>
                                    {{ $g->nama }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </form>
        </div>

        <!-- ================= DESKTOP TABLE ================= -->
        <div class="hidden sm:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gudang</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($data as $index => $stock_produk)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $data->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $stock_produk->jumlah }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $stock_produk->produk->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $stock_produk->gudang->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $stock_produk->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                   <a href="{{ route('crud_stocks.edit',$stock_produk->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edits
                                    </a>
                                    <form action="{{ route('crud_stocks.destroy',$stock_produk->id) }}" method="post" class="form">
                                    <form action="{{ route('crud_stocks.destroy',$stock_produk->id) }}" method="post" class="form">
                                        @csrf
                                        @method('delete')
                                        <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">Tidak ada data stok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= MOBILE CARD ================= -->
        <div class="block sm:hidden space-y-4 mt-4">
            @forelse ($data as $index => $stock_produk)
            <div class="p-4 bg-white rounded-lg shadow border animate-fade-in-up">
                <div class="text-sm text-gray-500 mb-2">No: {{ $data->firstItem() + $index }}</div>
                <div class="font-medium text-gray-800">Jumlah: {{ $stock_produk->jumlah }}</div>
                <div class="text-gray-600">Produk: {{ $stock_produk->produk->nama }}</div>
                <div class="text-gray-600">Gudang: {{ $stock_produk->gudang->nama }}</div>
                <div class="text-gray-800 font-medium">Status: {{ $stock_produk->status }}</div>
                <div class="mt-3 flex space-x-2">
                    <a href="{{ route('crud_stocks.edit',$stock_produk->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('crud_stocks.destroy',$stock_produk->id) }}" method="post" class="form">
                        @csrf
                        @method('delete')
                        <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-4 bg-white rounded-lg shadow border text-center text-gray-400 animate-fade-in-up">
                Tidak ada data stok.
            </div>
            @endforelse
        </div>

        <br>
        <!-- Pagination -->
        <div id="paginate" class="mt-4 flex justify-center animate-fade-in-up" style="animation-delay: 0.3s">
        {{ $data->links('pagination::tailwind') }}
        </div>
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
    fetch(`/dashboard/org_gudang/crud_produk/${id}`)
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
(function () {
    //taruh id di form search
    const form = document.getElementById('form-s');
    //name di input search harus search
    const searchInput = document.getElementById('search');
    // select filters
    const produkSelect = document.getElementById('produk');
    const gudangSelect = document.getElementById('gudang');
    //div awal table id
    const tableContainer = document.getElementById('div-container');
    //div awal pagination id
    const paginationContainer = document.getElementById('paginate');

    if (!form || !searchInput || !tableContainer || !paginationContainer) {
        return;
    }

    // debounce helper
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
        const p = produkSelect ? produkSelect.value : '';
        const g = gudangSelect ? gudangSelect.value : '';

        if (s.length) params.set('search', s);
        if (p) params.set('produk', p);
        if (g) params.set('gudang', g);
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
            //ganti juga sesuai id diatas
            const newTable = doc.getElementById('div-container');
            const newPagination = doc.getElementById('paginate');

            if (newTable) {
                tableContainer.innerHTML = newTable.innerHTML;
            }
            if (newPagination) {
                paginationContainer.innerHTML = newPagination.innerHTML;
            }

            if (push) {
                history.pushState(null, '', url);
            }

            // after replacing content, update selects/inputs from URL (in case server normalizes)
            const qs = new URL(url, window.location.origin).searchParams;
            if (searchInput) searchInput.value = qs.get('search') || '';
            if (produkSelect) produkSelect.value = qs.get('produk') || '';
            if (gudangSelect) gudangSelect.value = qs.get('gudang') || '';

            // Re-bind pagination links after replacing markup
            rebindPaginationLinks();
        } catch (err) {
            console.error('Live fetch error', err);
        }
    }

    const performSearch = debounce(() => {
        const url = buildUrl();
        fetchAndReplace(url);
    }, 350);

    // events: search input and selects
    searchInput.addEventListener('input', performSearch);
    if (produkSelect) produkSelect.addEventListener('change', () => { fetchAndReplace(buildUrl()); });
    if (gudangSelect) gudangSelect.addEventListener('change', () => { fetchAndReplace(buildUrl()); });

    // prevent full form submit (enter key)
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const url = buildUrl();
        fetchAndReplace(url);
    });

    // handle browser back/forward: update input and fetch content
    window.addEventListener('popstate', function () {
        const full = window.location.pathname + window.location.search;
        fetchAndReplace(full, false);
        const qs = new URLSearchParams(window.location.search);
        searchInput.value = qs.get('search') || '';
        if (produkSelect) produkSelect.value = qs.get('produk') || '';
        if (gudangSelect) gudangSelect.value = qs.get('gudang') || '';
    });

    function rebindPaginationLinks() {
        const links = paginationContainer.querySelectorAll('a');
        links.forEach(link => {
            // remove previous handlers to avoid duplicates
            link.replaceWith(link.cloneNode(true));
        });
        // re-select after clone
        const newLinks = paginationContainer.querySelectorAll('a');
        newLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (!href) return;
                e.preventDefault();
                fetchAndReplace(href);
            });
        });
    }

    // initial bind for existing pagination
    rebindPaginationLinks();

})();
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