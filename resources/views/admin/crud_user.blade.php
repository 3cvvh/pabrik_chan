@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">Daftar User</h1>
                <p class="text-gray-600">Kelola semua User dalam sistem</p>
            </div>
           <a href="{{ route('crud_user.create') }}"
            class="px-3 py-1.5 text-sm gap-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200 shadow flex items-center
                    sm:px-5 sm:py-2.5 sm:text-base sm:gap-2">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Stok Baru
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="mb-6 p-6 bg-white rounded-xl shadow-sm animate-fade-in-up" style="animation-delay: 0.1s">
            <form onsubmit="return false;" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari User</label>
                    <div class="relative">
                        <input autocomplete="off" id="search" type="text"
                            placeholder="Cari berdasarkan nama atau email..."
                            class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="w-48">
                    <label for="roles_key" class="block text-sm font-medium text-gray-700 mb-1">Filter Role</label>
                    <select id="roles_key" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200">
                        <option value="">Semua Role</option>
                        @foreach ($role as $item)
                            <option value="{{ strtolower($item->name) }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Table (Desktop) -->
        <div class="hidden sm:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody id="users-tbody" class="bg-white divide-y divide-gray-200">
                    @foreach ($data as $index => $user)
                    <tr class="hover:bg-gray-50 transition-all duration-200 user-row"
                        data-name="{{ strtolower($user->name) }}"
                        data-email="{{ strtolower($user->email) }}"
                        data-role="{{ strtolower($user->role->name) }}">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $data->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-indigo-700 font-medium text-sm">{{ substr($user->name, 0, 2) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                {{ $user->role->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <a href="{{ route('crud_user.edit',$user->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('crud_user.destroy',$user->id) }}" method="post" class="delete-form">
                                    @csrf
                                    @method('delete')
                                    <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Card (Mobile) -->
        <div id="users-cards" class="sm:hidden space-y-4 mt-6">
            @foreach ($data as $index => $user)
            <div class="user-card p-4 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition"
                data-name="{{ strtolower($user->name) }}"
                data-email="{{ strtolower($user->email) }}"
                data-role="{{ strtolower($user->role->name) }}">
                <!-- Nomor & Role -->
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs text-gray-500">#{{ $data->firstItem() + $index }}</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">{{ $user->role->name }}</span>
                </div>
        
                <!-- Nama & Email -->
                <p class="text-base font-bold text-gray-800">{{ $user->name }}</p>
                <p class="text-sm text-gray-500 mb-3">{{ $user->email }}</p>
        
                <!-- Tombol Aksi (SAMAIN kayak laptop/transaksi) -->
                <div class="flex justify-end space-x-2">
                    <!-- Tombol Edit -->
                    <a href="{{ route('crud_user.edit',$user->id) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
        
                    <!-- Tombol Hapus -->
                    <form action="{{ route('crud_user.destroy',$user->id) }}" method="post">
                        @csrf
                        @method('delete')
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
            @endforeach
        </div>
        <br>
        {{ $data->links('pagination::tailwind') }}
    </div>
</div>

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
@if (session('tambah'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('tambah') }}',
        timer: 1600,
        showConfirmButton: false
    });

@endif
@if (session('edit'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('edit') }}',
        timer: 1600,
        showConfirmButton: false
    });

@endif
</script>

<script>
(function(){
    // Live search for user — debounce, JSON headers, render rows
    const input = document.getElementById('search');
    const roleSelect = document.getElementById('roles_key');
    const tbody = document.getElementById('users-tbody');
    const base = '{{ route("crud_user.index") }}';
    let timer = null;

    function renderList(users){
        if (!users || users.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">Tidak ada hasil</td></tr>';
            return;
        }
        tbody.innerHTML = users.map((u, i) => `
            <tr class="hover:bg-gray-50 transition-all duration-200">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${i+1}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-700 font-medium text-sm">${(u.name||'').substr(0,2)}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${u.name || ''}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${u.email || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">${u.role_name || ''}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex space-x-2">
                        <a href="${base}/${u.id}/edit" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-medium">Edit</a>
                        <form action="${base}/${u.id}" method="post" class="delete-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="delete">
                            <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-sm font-medium">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    input.addEventListener('input', function() {
        const value = this.value;
        const role = roleSelect ? roleSelect.value : '';
        clearTimeout(timer);
        timer = setTimeout(() => {
            const params = [];
            if (value) params.push('search=' + encodeURIComponent(value));
            if (role && role !== '0') params.push('roles_key=' + encodeURIComponent(role));
            fetch(base + (params.length ? '?' + params.join('&') : ''), {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(users => {
                renderList(users);
            });
        }, 300);
    });

    if (roleSelect) {
        roleSelect.addEventListener('change', function(){
            const value = input.value;
            const role = this.value;
            clearTimeout(timer);
            timer = setTimeout(() => {
                const params = [];
                if (value) params.push('search=' + encodeURIComponent(value));
                if (role && role !== '0') params.push('roles_key=' + encodeURIComponent(role));
                fetch(base + (params.length ? '?' + params.join('&') : ''), {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(users => {
                    renderList(users);
                });
            }, 300);
        });
    }
})();
</script>
<script>
<x-alert></x-alert>
</script>

@endsection
