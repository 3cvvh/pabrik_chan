<nav class="bg-blue-500 border-t-2 border-black px-8 py-3 flex items-center justify-between shadow-lg">
    <div class="text-white font-bold text-xl tracking-wide drop-shadow">
        Welcome
        @if (Auth::user()->role_id === 1)
            admin
        @elseif (Auth::user()->role_id === 2)
            orang gudang
        @elseif (Auth::user()->role_id === 3)
            owner
        @else
            super admin
        @endif
    </div>
    <div class="flex items-center gap-2 sm:gap-4 md:gap-6">
        @if(Auth::user()->role_id == 4)
                <a href="/dashboard/super_admin"
                class="font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200
                {{ request()->is('dashboard/super_admin') ? 'bg-white text-blue-900 border border-black' : 'text-white hover:bg-blue-600 hover:bg-blue-100' }}">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
            <a href="/dashboard/super_admin/crud_pabrik"
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/super_admin/crud_pabrik*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                <i class="fas fa-industry w-5 h-5 mr-2"></i>
                Pabrik
            </a>
            <a href="/dashboard/super_admin/crud_users"
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/super_admin/crud_users*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                <i class="fas fa-users w-5 h-5 mr-2"></i>
                user
            </a>
        @endif

        @if(Auth::user()->role_id === 2)
            <a href="/dashboard/org_gudang"
                class="font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200
                {{ request()->is('dashboard/org_gudang') ? 'bg-white text-blue-900 border border-black' : 'text-white hover:bg-blue-600 hover:bg-blue-100' }}">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
        @endif

        @if(auth()->user()->role_id === 1)
            <div class="flex items-center gap-2 sm:gap-4 md:gap-6">
                <a href="{{ route('admin.index') }}"
                class="font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200
                {{ request()->is('dashboard/admin') ? 'bg-white text-blue-900 border border-black' : 'text-white hover:bg-blue-600 hover:bg-blue-100' }}">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
                <a href="/dashboard/admin/crud_user"
                    class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                    {{ request()->is('dashboard/admin/crud_user*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                    <i class="fas fa-user w-5 h-5 mr-1"></i>
                    user
                </a>
                <a href="{{ route('crud_transaksi.index') }}"
                    class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                    {{ request()->is('dashboard/admin/crud_transaksi*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                    <i class="fas fa-exchange-alt w-5 h-5 mr-1"></i>
                    Transaksi
                </a>
                <a href="/dashboard/admin/crud_pembeli"
                    class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                    {{ request()->is('dashboard/admin/crud_pembeli*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                    <i class="fas fa-user-tag w-5 h-5 mr-1"></i>
                    Pembeli
                </a>
                <a href="{{ route('produk.index') }}"
                    class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                    {{ request()->is('dashboard/admin/produk*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                    <i class="fas fa-boxes w-5 h-5 mr-1"></i>
                    Produk
                </a>
                <a href="/dashboard/admin/crud_gudang"
                    class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                    {{ request()->is('dashboard/admin/crud_gudang*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                    <i class="fas fa-warehouse w-5 h-5 mr-1"></i>
                    gudang
                </a>
                <a href="{{ route('Stock_produk.index') }}"
                    class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                    {{ request()->is('dahboard/admin/Stock_produk*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                    <i class="fa fa-cubes w-5 h-5 mr-1"></i>
                    Stock
                </a>
            </div>
        @endif

        @if (auth()->user()->role_id === 2)
            <a href="{{ route('crud_produk.index') }}"
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/org_gudang/crud_produk*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                <i class="fas fa-boxes w-5 h-5 mr-1"></i>
                Produk
            </a>
            <a href="{{ route('crud_stocks.index') }}"
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/org_gudang/crud_stocks*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                <i class="fa fa-cubes w-5 h-5 mr-1"></i>
                Stock
            </a>
        @endif

        @if (auth()->user()->role_id === 3)
            <a href="{{ route('owner.index') }}"
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/owner') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                <i class="fas fa-chart-bar w-5 h-5 mr-1"></i>
                data laporan
            </a>
            <a href='{{ route('owner.dash') }}'
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/owner/dawgboard') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                <i class="fa fa-home w-5 h-5 mr-1"></i>
                dashboard
            </a>
        @endif

        <form action="{{ route('logout') }}" method="post" class="ml-2 sm:ml-4" id="logout-form">
            @csrf
            <button type="button"
                onclick="confirmLogout()"
                class="flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200">
                <i class="fas fa-sign-out-alt mr-2"></i>
                logout
            </button>
        </form>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan keluar dari sistem",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
