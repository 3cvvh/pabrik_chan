@extends('layout.main')
@section('content')

<div class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-50 min-h-screen">
    <!-- Header -->
    <x-navbar></x-navbar>

    <!-- Welcome Card -->
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-lg bg-white border border-blue-200 rounded-2xl shadow-xl p-10 text-center">
            <h2 class="text-2xl font-bold text-blue-700 mb-3 tracking-wide">Welcome To Factory</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Terimakasih telah bergabung di Factory<br>
                Anda login menggunakan akun <span class="text-blue-600 font-semibold">owner</span>
            </p>
            <a href="#"
               class="px-6 py-2 font-semibold text-blue-700 bg-blue-50 border border-blue-300 rounded-lg hover:bg-blue-200 hover:shadow transition-all duration-200">
               Dashboard Owner
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto mt-12 bg-white border border-blue-100 rounded-2xl shadow-2xl p-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 mb-1">Halaman Dashboard Owner</h2>
                <p class="text-base text-gray-500">History Data Transaksi Barang</p>
            </div>
            <a href="{{ route('owner.laporanbos') }}" target="_blank"
               class="px-6 py-2 font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition">
               Generate Semua Laporan
            </a>
        </div>

        <!-- Search -->
        <form id="searchForm" class="flex flex-col sm:flex-row items-center gap-3 mb-8" method="GET" action="">
            <input id="searchInput" name="search" type="text" placeholder="Cari transaksi..."
                   class="flex-1 px-4 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 transition" />
            <!-- Filter Pembeli -->
            <select id="pembeliSelect" name="pembeli_id" class="px-4 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                <option value="">Semua Pembeli</option>
                @foreach ($pembelis as $pembeli)
                    <option value="{{ $pembeli->id }}" {{ request('pembeli_id') == $pembeli->id ? 'selected' : '' }}>
                        {{ $pembeli->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- ==========================
             TABEL (desktop)
        =========================== -->
        <div class="hidden sm:block overflow-x-auto border border-gray-200 rounded-xl shadow">
            <table class="min-w-full bg-white rounded-xl">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-blue-400 text-black">
                        <th class="py-3 px-4 text-left font-semibold">No</th>
                        <th class="py-3 px-4 text-left font-semibold">Nama Transaksi</th>
                        <th class="py-3 px-4 text-left font-semibold">Customer</th>
                        <th class="py-3 px-4 text-left font-semibold">Status Order</th>
                        <th class="py-3 px-4 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody id="transaksiTbody" class="text-gray-700">
                    @forelse ($transaksi as $index => $item)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="py-3 px-4">{{ $transaksi->firstItem() + $index}}</td>
                            <td class="py-3 px-4 font-medium">{{ $item->judul }}</td>
                            <td class="py-3 px-4">{{ $item->pembeli->name }}</td>
                            <td class="py-3 px-4">
                                <span class="px-4 py-1 text-xs font-bold border border-gray-200 rounded-full shadow-sm
                                    {{ $item->status == 'completed'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('transaksi.show',$item->id) }}"
                                   class="px-5 py-1.5 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition">
                                   Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400">
                                Tidak ada data transaksi tersedia.
                            </td>
                        </tr>
                    @endforelse
            </table>
        </div>
        <br>

        <!-- ==========================
             CARD (mobile)
        =========================== -->
        <div class="sm:hidden space-y-4 mt-6">
            @forelse ($transaksi as $index => $item)
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-500">#{{ $transaksi->firstItem() + $index}}</span>
                        <span class="text-sm font-semibold {{ $item->status == 'completed' ? 'text-green-600' : 'text-amber-600' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <p class="text-base font-bold text-gray-800">{{ $item->judul }}</p>
                    <p class="text-sm text-gray-500 mb-2">Customer: {{ $item->pembeli->name }}</p>
                    <div class="flex justify-end">
                        <a href="{{ route('transaksi.show',$item->id) }}"
                           class="px-4 py-1.5 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition">
                           Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-gray-400">
                    Tidak ada data transaksi tersedia.
                </div>
            @endforelse
        </div>

                {{-- pagination --}}
        {{ $transaksi->links('pagination::tailwind') }}
    </div>
</div>
<script>
    // Live search for produk — debounce, JSON headers, render rows
    let renderList = function(items) {
        const tbody = document.getElementById('produk');
        if (!items || items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-6 py-4 text-sm text-gray-500 text-center">
                        Data tidak ditemukan
                    </td>
                </tr>`;
            return;
        }
        tbody.innerHTML = items.map((produk, index) => `
            <tr class="hover:bg-gray-50 transition-all duration-200">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${index + 1}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-700 font-medium text-sm">${(produk.judul || '').substr(0,2)}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${produk.customer || ''}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${produk.status_order || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                        ${produk.role_name || ''}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${produk.pabrik_name || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex space-x-2">
                        <a href="/dashboard/super_admin/crud_users/${produk.id}/edit" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-medium">Edit</a>
                        <form action="/dashboard/super_admin/crud_users/${produk.id}" method="post" class="delete-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="delete">
                            <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-sm font-medium">Hapus</button>
                        </form>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    Rp ${Number(produk.harga).toLocaleString('id-ID')}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex space-x-2">
                        <a class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg text-sm font-medium transition-colors duration-200" href="/produk/${produk.id}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Details
                        </a>
                    </div>
                </td>
            </tr>
        `).join('');
    }
    // Debounce helper
    function debounce(fn, delay) {
        let timer = null;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    // Render transaksi rows
    function renderTransaksi(items) {
        const tbody = document.getElementById('transaksiTbody');
        if (!items || items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-6 text-center text-lg text-gray-400">
                        Tidak ada data transaksi tersedia.
                    </td>
                </tr>`;
            return;
        }
        tbody.innerHTML = items.map((item, index) => `
            <tr class="border-b hover:bg-blue-50 transition">
                <td class="py-3 px-4">${index + 1}</td>
                <td class="py-3 px-4 font-medium">${item.judul}</td>
                <td class="py-3 px-4">${item.pembeli?.name || ''}</td>
                <td class="py-3 px-4">
                    <span class="px-4 py-1 text-xs font-bold border border-gray-200 rounded-full shadow-sm
                        ${item.status == 'completed'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-amber-100 text-amber-700'}">
                        ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                    </span>
                </td>
                <td class="py-3 px-4">
                    <a href="/transaksi/${item.id}" class="px-5 py-1.5 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition">
                        Detail
                    </a>
                </td>
            </tr>
        `).join('');
    }

    // Fetch transaksi data
    function fetchTransaksi() {
        const search = document.getElementById('searchInput').value;
        const pembeli_id = document.getElementById('pembeliSelect').value;
        fetch(`?search=${encodeURIComponent(search)}&pembeli_id=${encodeURIComponent(pembeli_id)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            renderTransaksi(data.transaksi);
        });
    }

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', debounce(fetchTransaksi, 400));
    document.getElementById('pembeliSelect').addEventListener('change', fetchTransaksi);

    // Optionally, fetch on page load
    // fetchTransaksi();
</script>
@endsection

