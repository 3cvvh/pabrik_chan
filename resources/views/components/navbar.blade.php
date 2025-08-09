<nav class="bg-blue-500 border-t-2 border-black px-8 py-3 flex items-center justify-between">
    <div class="text-white font-bold text-xl">
        Welcome @if (Auth::user()->role_id === 1)
            admin
        @elseif (Auth::user()->role_id === 2)
            orang gudang
        @elseif (Auth::user()->role_id === 3)
            owner
            @else
            super admin
        @endif
    </div>
    <div class="flex items-center space-x-4">
        @if(Auth::user()->role_id === 2)
            <a href="/dashboard/org_gudang" class="bg-white text-blue-600 font-semibold px-4 py-1 rounded shadow hover:bg-blue-100 transition">Dashboard</a>
        @endif
        @if(auth()->user()->role_id === 1)
        <a href="/transaksi" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v5a2 2 0 002 2h8a2 2 0 002-2v-5a2 2 0 00-2-2zm-8-2a3 3 0 016 0v2H9V7zm8 7a1 1 0 01-1 1H5a1 1 0 01-1-1v-5a1 1 0 011-1h10a1 1 0 011 1v5z"/></svg>
            Transaksi
        </a>
        <a href="/dasboard/admin/crud_pabrik" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zm-3 5a5 5 0 00-5 5v1h10v-1a5 5 0 00-5-5z"/></svg>
            Pabrik
        </a>
        <a href="/pembelis" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zm-3 5a5 5 0 00-5 5v1h10v-1a5 5 0 00-5-5z"/></svg>
            Pembeli
        </a>
        <a href="/produk" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zm-3 5a5 5 0 00-5 5v1h10v-1a5 5 0 00-5-5z"/></svg>
            Produk
        </a>
        <a href="/gudang" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zm-3 5a5 5 0 00-5 5v1h10v-1a5 5 0 00-5-5z"/></svg>
            gudang
        </a>
        @endif
        @if (auth()->user()->role_id === 2)
        <a href="/dashboard/org_gudang/stock" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zm-3 5a5 5 0 00-5 5v1h10v-1a5 5 0 00-5-5z"/></svg>
            Produk
        </a>
        @endif
        @if (auth()->user()->role_id === 3)
        <a href="/produk" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zm-3 5a5 5 0 00-5 5v1h10v-1a5 5 0 00-5-5z"/></svg>
            data laporan
        </a>
        @endif
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-1 rounded transition" type="submit">logout</button>
        </form>
    </div>
</nav>