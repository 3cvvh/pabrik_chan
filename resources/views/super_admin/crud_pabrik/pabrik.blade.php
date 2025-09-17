@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">Data Pabrik</h1>
                <p class="text-gray-600">Kelola semua pabrik dalam sistem</p>
            </div>
            <a href="/dashboard/super_admin/crud_pabrik/create">
                <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pabrik
                </button>
            </a>
        </div>

        <!-- Search -->
        <div class="mb-6 p-6 bg-white rounded-xl shadow-sm animate-fade-in-up" style="animation-delay: 0.1s">
            <form onsubmit="return false" id="search-form" action="" method="get" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Pabrik</label>
                    <div class="relative">
                        <input autocomplete="off" name="search" id="search" type="text"
                            placeholder="Cari berdasarkan nama atau alamat..."
                            class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table (Desktop) -->
        <div class="hidden sm:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-x-auto animate-fade-in-up" style="animation-delay: 0.2s">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama Pabrik</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Alamat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Logo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pabrik-tbody" class="bg-white divide-y divide-gray-200">
                    @forelse($pabrik as $index => $pabrik1)
                    <tr class="hover:bg-gray-50 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $index+1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $pabrik1->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $pabrik1->alamat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($pabrik1->gambar)
                                <img src="{{ asset('storage/' . $pabrik1->gambar) }}" alt="Logo Pabrik" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <span class="px-3 py-1 text-sm text-gray-500 bg-gray-100 rounded-full">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <a href="/dashboard/super_admin/crud_pabrik/{{ $pabrik1->id }}/edit"
                                   class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="/dashboard/super_admin/crud_pabrik/{{ $pabrik1->id }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
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
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card (Mobile) -->
        <div id="pabrik-cards" class="sm:hidden space-y-4 mt-6">
            @forelse($pabrik as $index => $pabrik1)
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-gray-500">#{{ $index+1 }}</span>
                    <div>
                        @if ($pabrik1->gambar)
                            <img src="{{ asset('storage/' . $pabrik1->gambar) }}" alt="Logo Pabrik" class="h-8 w-8 rounded-full object-cover">
                        @else
                            <span class="px-2 py-0.5 text-xs text-gray-500 bg-gray-100 rounded-full">No Logo</span>
                        @endif
                    </div>
                </div>
                <p class="text-base font-bold text-gray-800">{{ $pabrik1->name }}</p>
                <p class="text-sm text-gray-500 mb-2">{{ $pabrik1->alamat }}</p>
                <div class="flex justify-end gap-2 mt-2">
                    <a href="/dashboard/super_admin/crud_pabrik/{{ $pabrik1->id }}/edit"
                        class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="/dashboard/super_admin/crud_pabrik/{{ $pabrik1->id }}" method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete(this)"
                            class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-gray-500 bg-white rounded-lg">Data tidak ditemukan</div>
            @endforelse
        </div>
        <br>
        {{-- pagination --}}
        {{ $pabrik->links('pagination::tailwind') }}
    </div>
</div>

<style>
@keyframes fade-in { from { opacity:0 } to { opacity:1 } }
@keyframes fade-in-up { from { opacity:0; transform:translateY(20px);} to { opacity:1; transform:translateY(0);} }
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
@if(session('tambah'))
    Swal.fire({icon:'success',title:'Berhasil!',text:'{{ session('tambah') }}',timer:1500,showConfirmButton:false});
@endif
@if(session('edit'))
    Swal.fire({icon:'success',title:'Berhasil!',text:'{{ session('edit') }}',timer:1500,showConfirmButton:false});
@endif
<x-alert></x-alert>
</script>
<script>
(function(){
    const input = document.getElementById('search');
    const tbody = document.getElementById('pabrik-tbody');
    const cards = document.getElementById('pabrik-cards');
    let timer = null;

    function renderList(items){
        // Desktop
        if (window.innerWidth >= 640) {
            if (!items || items.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">Data tidak ditemukan</td></tr>';
                return;
            }
            tbody.innerHTML = items.map((p, i) => `
                <tr class="hover:bg-gray-50 transition-all duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${i+1}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${p.name || ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${p.alamat || ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${p.gambar_url ? `<img src="${p.gambar_url}" class="h-10 w-10 rounded-full object-cover">` : `<span class="px-3 py-1 text-sm text-gray-500 bg-gray-100 rounded-full">Tidak ada gambar</span>`}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-2">
                            <a href="/dashboard/super_admin/crud_pabrik/${p.id}/edit"
                                class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <form action="/dashboard/super_admin/crud_pabrik/${p.id}" method="POST" class="inline delete-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" onclick="confirmDelete(this)"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `).join('');
        } else {
            // Mobile
            if (!items || items.length === 0) {
                cards.innerHTML = '<div class="p-4 text-center text-gray-500 bg-white rounded-lg">Data tidak ditemukan</div>';
                return;
            }
            cards.innerHTML = items.map((p, i) => `
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-500">#${i+1}</span>
                        ${p.gambar_url ? `<img src="${p.gambar_url}" class="h-8 w-8 rounded-full object-cover">` : `<span class="px-2 py-0.5 text-xs text-gray-500 bg-gray-100 rounded-full">No Logo</span>`}
                    </div>
                    <p class="text-base font-bold text-gray-800">${p.name || ''}</p>
                    <p class="text-sm text-gray-500 mb-2">${p.alamat || ''}</p>
                    <div class="flex justify-end gap-2 mt-2">
                        <a href="/dashboard/super_admin/crud_pabrik/${p.id}/edit"
                            class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="/dashboard/super_admin/crud_pabrik/${p.id}" method="POST" class="inline delete-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" onclick="confirmDelete(this)"
                                class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            `).join('');
        }
    }

    async function fetchList(url){
        const res = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });
        if (!res.ok) {
            const text = await res.text();
            throw new Error(res.status + ' ' + res.statusText + '\n' + text);
        }
        return res.json();
    }

    function doSearch(q){
        const base = '{{ route("crud_pabrik.index") }}';
        const url = (q && q.trim() !== '') ? `${base}?search=${encodeURIComponent(q)}` : base;
        fetchList(url)
            .then(data => {
                const normalized = data.map(item => ({
                    ...item,
                    gambar_url: item.gambar ? ('/storage/' + item.gambar) : null
                }));
                renderList(normalized);
            })
            .catch(err => {
                console.error('Pabrik live search error:', err);
                if (window.innerWidth >= 640) {
                    tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-sm text-red-500 text-center">Terjadi kesalahan saat mengambil data</td></tr>';
                } else {
                    cards.innerHTML = '<div class="p-4 text-center text-red-500 bg-white rounded-lg">Terjadi kesalahan saat mengambil data</div>';
                }
            });
    }

    input.addEventListener('input', function(e){
        clearTimeout(timer);
        const q = e.target.value;
        timer = setTimeout(() => doSearch(q), 300);
    });

    // Responsive: re-render on resize
    window.addEventListener('resize', function() {
        doSearch(input.value);
    });
})();
</script>
@endsection