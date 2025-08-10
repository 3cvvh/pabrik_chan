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
    <div class="flex items-center gap-6">
        @if(Auth::user()->role_id == 4)
         <a href="/dashboard/super_admin/crud_pabrik" class="flex items-center text-white font-medium hover:text-blue-200 transition px-3 py-2"> <!-- Added px-3 py-2 -->
            <i class="fas fa-industry w-5 h-5 mr-2"></i>
            Pabrik
        </a>
         <a href="/dashboard/super_admin/crud_users" class="flex items-center text-white font-medium hover:text-blue-200 transition px-3 py-2">
            <i class="fas fa-users w-5 h-5 mr-2"></i>
            user
        </a>
        @endif
        @if(Auth::user()->role_id === 2)
            <a href="/dashboard/org_gudang" class="bg-white text-blue-600 font-semibold px-6 py-2 rounded shadow hover:bg-blue-100 transition"> <!-- Increased padding -->
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
        @endif
        @if(auth()->user()->role_id === 1)
            <div class="flex items-center gap-6">
            <a href="/dashboard/admin/crud_user" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <i class="fas fa-user w-5 h-5 mr-1"></i>
            user
        </a>
        <a href="{{ route('crud_transaksi.index') }}" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <i class="fas fa-exchange-alt w-5 h-5 mr-1"></i>
            Transaksi
        </a>
        <a href="/dashboard/admin/pembeli" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <i class="fas fa-user-tag w-5 h-5 mr-1"></i>
            Pembeli
        </a>
        <a href="/dashboard/admin/produk" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <i class="fas fa-boxes w-5 h-5 mr-1"></i>
            Produk
        </a>
        <a href="dashboard/admin/gudang" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <i class="fas fa-warehouse w-5 h-5 mr-1"></i>
            gudang
        </a>
            </div>
        @endif
        @if (auth()->user()->role_id === 2)
        <a href="/dashboard/orang_gudang/Produk" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <i class="fas fa-boxes w-5 h-5 mr-1"></i>
            Produk
        </a>
        @endif
        @if (auth()->user()->role_id === 3)
        <a href="/dashboard/owner" class="flex items-center text-white font-medium hover:text-blue-200 transition">
            <i class="fas fa-chart-bar w-5 h-5 mr-1"></i>
            data laporan
        </a>
        @endif
        <form action="{{ route('logout') }}" method="post" class="ml-6" id="logout-form">
            @csrf
            <button type="button" onclick="confirmLogout()" class="flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded transition">
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
