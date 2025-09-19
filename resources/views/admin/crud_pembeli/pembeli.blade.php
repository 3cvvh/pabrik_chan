@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">Daftar Pembeli</h1>
                <p class="text-gray-600">Kelola semua pembeli dalam satu tempat</p>
            </div>
            <a href="{{ route('crud_pembeli.create') }}">
                <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pembeli
                </button>
            </a>
        </div>

        <!-- Search -->
        <div class="mb-6 p-6 bg-white rounded-xl shadow-sm animate-fade-in-up" style="animation-delay: 0.1s">
            <form id="liveFilterForm" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Pembeli</label>
                    <div class="relative">
                        <input autocomplete="off" name="search" id="search" type="text"
                            placeholder="Cari pembeli..."
                            class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200"
                            value="{{ request('search') }}">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabel (Desktop) -->
        <div id="tableContainer" class="hidden sm:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pabrik</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No Telepon</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $index => $pembeli)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $data->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $pembeli->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $pembeli->pabrik->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $pembeli->alamat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $pembeli->no_telepon }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('crud_pembeli.edit',$pembeli->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg text-sm font-medium transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('crud_pembeli.destroy',$pembeli->id) }}" method="POST" class="delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-4 text-gray-500">Data tidak ditemukan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cards (Mobile) -->
        <div class="sm:hidden space-y-4 mt-6">
            @forelse($data as $index => $pembeli)
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition">
                <div class="flex justify-between mb-2">
                    <span class="text-xs text-gray-500">#{{ $data->firstItem() + $index }}</span>
                    <span class="text-xs font-medium text-indigo-600">{{ $pembeli->pabrik->name ?? '-' }}</span>
                </div>
                <p class="text-base font-bold text-gray-800">{{ $pembeli->name }}</p>
                <p class="text-sm text-gray-600">{{ $pembeli->alamat }}</p>
                <p class="text-sm text-gray-500 mb-3">{{ $pembeli->no_telepon }}</p>
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('crud_pembeli.edit',$pembeli->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg text-sm font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                    <form action="{{ route('crud_pembeli.destroy',$pembeli->id) }}" method="POST" class="delete-form">
                        @csrf @method('DELETE')
                        <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500">Data tidak ditemukan</p>
            @endforelse
        </div>

        <br>
            {{ $data->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- tampilkan alert di luar tag <script> -->


<script>
    <x-alert></x-alert>
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

<!-- Replaced broken script: cleaned live-search (no rolesSelect), removed irrelevant functions -->
<script>
//livesearch
(function () {
    //taruh id di form search
    const form = document.getElementById('liveFilterForm');
    //name di input search harus search
    const searchInput = document.getElementById('search');
    //div awal table id
    const tableContainer = document.getElementById('tableContainer');
    //div awal pagination id
    const paginationContainer = document.getElementById('paginationContainer');

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
    searchInput.addEventListener('input', performSearch);

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

@endsection
