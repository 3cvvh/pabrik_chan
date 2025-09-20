@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header Section -->
        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">Daftars produk</h1>
            </div>
        </div>

        <!-- Search/Filter Section -->
        <div class="mb-6 p-6 bg-white rounded-xl shadow-sm animate-fade-in-up" style="animation-delay: 0.1s">
            <form id="form-search" action="" method="get" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                    <div class="relative">
                        <input autocomplete="off" name="search" id="search" type="text"
                            placeholder="Cari Produk..."
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

        <!-- TABEL - hanya tampil di desktop -->
        <div class="hidden sm:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pabrik</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($data as $index => $produk)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $data->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $produk->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $produk->pabrik->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($produk->gambar)
                                    <img class="mask-auto w-20 h-20" src="{{ asset('storage/' . $produk->gambar) }}" alt="">
                                @else
                                    Tidak ada gambar
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg text-sm font-medium transition-colors duration-200" href="{{ route('produk.show',$produk->id) }}">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $data->links('pagination::tailwind') }}
        </div>

        <!-- CARD VIEW - hanya tampil di HP -->
        <div class="sm:hidden space-y-4">
            @foreach ($data as $index => $produk)
                <div class="bg-white rounded-xl shadow p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-gray-500">#{{ $data->firstItem() + $index }}</span>
                        <span class="text-sm font-semibold text-indigo-600">{{ $produk->pabrik->name }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $produk->nama }}</h3>
                    <p class="text-sm text-gray-700">Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    @if($produk->gambar)
                        <img class="mt-2 rounded-lg w-full h-40 object-cover" src="{{ asset('storage/' . $produk->gambar) }}" alt="">
                    @endif
                    <div class="mt-3 flex justify-end">
                        <a href="{{ route('produk.show',$produk->id) }}" class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-medium hover:bg-emerald-200 transition">
                            Detail
                        </a>
                    </div>
                </div>
            @endforeach
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
@if(session('berhasil'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('berhasil') }}',
        timer: 1500,
        showConfirmButton: false
    });
@endif
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
(function () {
    const form = document.getElementById('form-search');
    const searchInput = document.getElementById('search');
    const tableContainer = document.getElementById('divtable');
    const paginationContainer = document.getElementById('paginationContainer');

    if (!form || !searchInput || !tableContainer || !paginationContainer) {
        return;
    }

    // simple debounce
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

            const newTable = doc.getElementById('tableContainer');
            const newPagination = doc.getElementById('paginationContainer');

            if (newTable) {
                tableContainer.innerHTML = newTable.innerHTML;
            }
            if (newPagination) {
                paginationContainer.innerHTML = newPagination.innerHTML;
            }

            if (push) {
                history.pushState(null, '', url);
            }

            // Re-attach click listeners for pagination links inside paginationContainer
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

    // prevent full form submit (enter key)
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const url = buildUrl();
        fetchAndReplace(url);
    });

    // handle browser back/forward
    window.addEventListener('popstate', function () {
        fetchAndReplace(window.location.pathname + window.location.search, false);
        const qs = new URLSearchParams(window.location.search);
        searchInput.value = qs.get('search') || '';
    });

    function rebindPaginationLinks() {
        const links = paginationContainer.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (!href) return;
                e.preventDefault();
                fetchAndReplace(href);
            });
        });
    }

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
