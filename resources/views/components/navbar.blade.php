<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'MyApp') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="fixed top-0 left-0 right-0 bg-blue-500 border-t-2 border-black px-6 py-3 flex items-center justify-between shadow-lg z-50">
        <!-- Welcome -->
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

        <!-- Desktop Menu -->
        <div class="hidden sm:flex items-center gap-2 md:gap-4">
            {{-- === Super Admin === --}}
            @if(Auth::user()->role_id == 4)
                <a href="/dashboard/super_admin"
                    class="font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200
                    {{ request()->is('dashboard/super_admin') ? 'bg-white text-blue-900 border border-black' : 'text-white hover:bg-blue-600 hover:bg-blue-100' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="/dashboard/super_admin/crud_pabrik"
                    class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                    {{ request()->is('dashboard/super_admin/crud_pabrik*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                    <i class="fas fa-industry w-5 h-5 mr-2"></i>Pabrik
                </a>
                <a href="/dashboard/super_admin/crud_users"
                    class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                    {{ request()->is('dashboard/super_admin/crud_users*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                    <i class="fas fa-users w-5 h-5 mr-2"></i>User
                </a>
            @endif

            {{-- === Admin === --}}
            @if(auth()->user()->role_id === 1)
                <a href="{{ route('admin.index') }}"
                   class="flex items-center px-4 py-2 rounded-lg transition duration-200
                   {{ request()->is('dashboard/admin') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                   <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="/dashboard/admin/crud_user"
                   class="flex items-center px-4 py-2 rounded-lg transition duration-200
                   {{ request()->is('dashboard/admin/crud_user*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                   <i class="fas fa-user mr-2"></i>User
                </a>
                <a href="{{ route('crud_transaksi.index') }}"
                   class="flex items-center px-4 py-2 rounded-lg transition duration-200
                   {{ request()->is('dashboard/admin/crud_transaksi*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                   <i class="fas fa-exchange-alt mr-2"></i>Transaksi
                </a>
                <a href="/dashboard/admin/crud_pembeli"
                   class="flex items-center px-4 py-2 rounded-lg transition duration-200
                   {{ request()->is('dashboard/admin/crud_pembeli*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                   <i class="fas fa-user-tag mr-2"></i>Pembeli
                </a>
                <a href="{{ route('produk.index') }}"
                   class="flex items-center px-4 py-2 rounded-lg transition duration-200
                   {{ request()->is('dashboard/admin/produk*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                   <i class="fas fa-boxes mr-2"></i>Produk
                </a>
                <a href="/dashboard/admin/crud_gudang"
                   class="flex items-center px-4 py-2 rounded-lg transition duration-200
                   {{ request()->is('dashboard/admin/crud_gudang*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                   <i class="fas fa-warehouse mr-2"></i>Gudang
                </a>
                 <a href="{{ route('Stock_produk.index') }}"
                    class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                    {{ request()->is('dahboard/admin/Stock_produk*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                    <i class="fa fa-cubes w-5 h-5 mr-1"></i>Stock
                </a>
            @endif

            {{-- === Orang Gudang === --}}
            @if(auth()->user()->role_id === 2)
                <a href="/dashboard/org_gudang"
                    class="font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200
                    {{ request()->is('dashboard/org_gudang') ? 'bg-white text-blue-900 border border-black' : 'text-white hover:bg-blue-600 hover:bg-blue-100' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('crud_produk.index') }}"
                   class="flex items-center px-4 py-2 rounded-lg transition duration-200
                   {{ request()->is('dashboard/org_gudang/crud_produk*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                   <i class="fas fa-boxes mr-2"></i>Produk
                </a>
                <a href="{{ route('crud_stocks.index') }}"
                   class="flex items-center px-4 py-2 rounded-lg transition duration-200
                   {{ request()->is('dashboard/org_gudang/crud_stocks*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                   <i class="fas fa-cubes mr-2"></i>Stock
                </a>
            @endif

            {{-- === Owner === --}}
            @if(auth()->user()->role_id === 3)
                  <a href="{{ route('owner.index') }}"
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/owner') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                <i class="fas fa-chart-bar w-5 h-5 mr-1"></i>data laporan
            </a>
            <a href='{{ route('owner.dash') }}'
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/owner/dawgboard') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                <i class="fa fa-home w-5 h-5 mr-1"></i>dashboard
            </a>
            @endif

            {{-- Logout --}}
            <form action="{{ route('logout') }}" method="post" class="ml-2 sm:ml-4">
                @csrf
                <button type="button"
                        onclick="confirmLogout(this)"
                        class="flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
        </div>

        <!-- Hamburger Button Mobile -->
        <button id="menu-btn" class="sm:hidden text-white text-2xl focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    {{-- Mobile Sidebar --}}
    <div id="mobile-menu" class="fixed inset-0 hidden z-40 sm:hidden">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div id="sidebar"
         class="absolute top-0 left-0 w-3/4 max-w-xs bg-blue-600 h-full p-6 flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out">
        <button id="close-btn" class="text-white text-2xl self-end"><i class="fas fa-times"></i></button>
        <div class="mt-8 flex flex-col gap-4">

                {{-- === Super Admin === --}}
                @if(Auth::user()->role_id == 4)
                    <a href="/dashboard/super_admin"
                        class="font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200
                        {{ request()->is('dashboard/super_admin') ? 'bg-white text-blue-900 border border-black' : 'text-white hover:bg-blue-600 hover:bg-blue-100' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="/dashboard/super_admin/crud_pabrik"
                        class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->is('dashboard/super_admin/crud_pabrik*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                        <i class="fas fa-industry w-5 h-5 mr-2"></i>Pabrik
                    </a>
                    <a href="/dashboard/super_admin/crud_users"
                        class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->is('dashboard/super_admin/crud_users*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                        <i class="fas fa-users w-5 h-5 mr-2"></i>Users
                    </a>
                @endif

                {{-- === Admin === --}}
                @if(auth()->user()->role_id === 1)
                    <a href="{{ route('admin.index') }}"
                        class="flex items-center px-4 py-2 rounded-lg transition duration-200
                        {{ request()->is('dashboard/admin') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="/dashboard/admin/crud_user"
                        class="flex items-center px-4 py-2 rounded-lg transition duration-200
                        {{ request()->is('dashboard/admin/crud_user*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                        <i class="fas fa-user mr-2"></i>User
                    </a>
                    <a href="{{ route('crud_transaksi.index') }}"
                        class="flex items-center px-4 py-2 rounded-lg transition duration-200
                        {{ request()->is('dashboard/admin/crud_transaksi*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                        <i class="fas fa-exchange-alt mr-2"></i>Transaksi
                    </a>
                    <a href="/dashboard/admin/crud_pembeli"
                        class="flex items-center px-4 py-2 rounded-lg transition duration-200
                        {{ request()->is('dashboard/admin/crud_pembeli*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                        <i class="fas fa-user-tag mr-2"></i>Pembeli
                    </a>
                    <a href="{{ route('produk.index') }}"
                        class="flex items-center px-4 py-2 rounded-lg transition duration-200
                        {{ request()->is('dashboard/admin/produk*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                        <i class="fas fa-boxes mr-2"></i>Produk
                    </a>
                    <a href="/dashboard/admin/crud_gudang"
                        class="flex items-center px-4 py-2 rounded-lg transition duration-200
                        {{ request()->is('dashboard/admin/crud_gudang*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                        <i class="fas fa-warehouse mr-2"></i>Gudang
                    </a>
                    <a href="{{ route('Stock_produk.index') }}"
                        class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->is('dashboard/admin/Stock_produk*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                        <i class="fa fa-cubes w-5 h-5 mr-1"></i>Stock
                    </a>
                @endif

                {{-- === Orang Gudang === --}}
                @if(auth()->user()->role_id === 2)
                    <a href="/dashboard/org_gudang"
                        class="font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200
                        {{ request()->is('dashboard/org_gudang') ? 'bg-white text-blue-900 border border-black' : 'text-white hover:bg-blue-600 hover:bg-blue-100' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('crud_produk.index') }}"
                        class="flex items-center px-4 py-2 rounded-lg transition duration-200
                        {{ request()->is('dashboard/org_gudang/crud_produk*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                        <i class="fas fa-boxes mr-2"></i>Produk
                    </a>
                    <a href="{{ route('crud_stocks.index') }}"
                        class="flex items-center px-4 py-2 rounded-lg transition duration-200
                        {{ request()->is('dashboard/org_gudang/crud_stocks*') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600' }}">
                        <i class="fas fa-cubes mr-2"></i>Stock
                    </a>
                @endif

                {{-- === Owner === --}}
                @if(auth()->user()->role_id === 3)
                       <a href="{{ route('owner.index') }}"
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/owner') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 d' }}">
                <i class="fas fa-chart-bar w-5 h-5 mr-1"></i>data laporan
            </a>
            <a href='{{ route('owner.dash') }}'
                class="flex items-center font-medium px-3 py-2 rounded-lg transition-all duration-200
                {{ request()->is('dashboard/owner/dawgboard') ? 'bg-white text-blue-900 shadow border border-black' : 'text-white hover:bg-blue-600 hover:text-white' }}">
                <i class="fa fa-home w-5 h-5 mr-1"></i>dashboard
            </a>
                @endif

                {{-- Logout Mobile --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" onclick="confirmLogout(this)" class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition duration-300 ease-in-out w-auto self-start flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main Content (kasih padding biar ga ketiban navbar) --}}
    <main class="pt-20 px-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout(btn) {
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
                    btn.closest('form').submit();
                }
            });
        }

        // Hamburger toggle
        document.addEventListener("DOMContentLoaded", () => {
            const menuBtn = document.getElementById('menu-btn');
            const closeBtn = document.getElementById('close-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const sidebar = document.getElementById('sidebar');
            const overlay = mobileMenu.querySelector('div.absolute');

            // fungsi buka sidebar
            function openSidebar() {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => sidebar.classList.remove('-translate-x-full'), 10);
            }

            // fungsi tutup sidebar
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                setTimeout(() => mobileMenu.classList.add('hidden'), 300);
            }

            // toggle dengan hamburger
            menuBtn.addEventListener('click', () => {
                if (mobileMenu.classList.contains('hidden')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            // tombol X
            closeBtn.addEventListener('click', closeSidebar);

            // klik overlay hitam
            overlay.addEventListener('click', closeSidebar);
        });
    </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
