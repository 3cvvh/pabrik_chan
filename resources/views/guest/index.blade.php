@extends("layout.main")
@section("content")
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-200">
    <div class="relative max-w-3xl w-full bg-white/90 p-10 rounded-3xl shadow-2xl text-center border border-blue-100">
        @auth
        <form method="POST" action="{{ route('logout') }}" class="absolute top-4 right-4 z-10">
            @csrf
            <button type="submit"
                class="px-4 py-2 bg-white text-blue-500 font-semibold rounded-lg shadow-lg border border-blue-300
                    hover:from-blue-600 hover:to-blue-800 hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-300 flex items-center gap-2 group">
                <span class="ml-1">Logout</span>
            </button>
        </form>
        @endauth

        <!-- Hero Illustration -->
        <div class="flex flex-col items-center mb-6">
            <div class="flex items-center gap-3 bg-white/70 px-5 py-2 rounded-lg shadow border border-blue-100">
                <img src="{{ asset('img/logopabrik.png')}}" alt="Pabrik" class="w-14 h-14 object-contain drop-shadow-lg">
                <span class="text-2xl font-bold text-blue-500 tracking-wide">Factorynize</span>
            </div>
        </div>

        <h1 class="text-4xl font-extrabold text-blue-800 mb-2 tracking-tight">Selamat datang di <span class="text-blue-500">Pabrik Chan</span></h1>
        <p class="text-lg text-gray-700 mb-8">
            Jelajahi situs pabrik kami dan mulai perjalanan Anda!
        </p>

        <!-- Dua kartu interaktif: Ajukan Bergabung & Buat Pabrik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mt-6">
            <a href="{{ route('guest.request_pabrik') }}"
               class="group block bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 shadow-lg border border-blue-100 hover:shadow-2xl hover:scale-105 transform transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-200"
               aria-label="Ajukan Bergabung ke Pabrik">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-4 text-blue-600 group-hover:bg-blue-200 transition">
                        <!-- users icon -->
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-1a4 4 0 00-3-3.87M9 20H4v-1a4 4 0 013-3.87M16 11a4 4 0 10-8 0 4 4 0 008 0z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h3 class="text-xl font-semibold text-blue-800">Ajukan Bergabung</h3>
                        <p class="mt-2 text-sm text-gray-600">Pilih pabrik yang ingin Anda masuki dan kirim permohonan. Tunggu konfirmasi dari admin pabrik.</p>
                        <div class="mt-4">
                            <span class="inline-block px-3 py-1 text-xs bg-blue-200 text-blue-800 rounded-full">Masuk ke pabrik yang ada</span>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('guest.form_pabrik') }}"
               class="group block bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 shadow-lg border border-blue-100 hover:shadow-2xl hover:scale-105 transform transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-200"
               aria-label="Buat Pabrik Baru">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-4 text-blue-600 group-hover:bg-blue-200 transition">
                        <!-- building icon -->
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 21h18M5 21V10l7-5 7 5v11M9 21V10m6 11V10" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <h3 class="text-xl font-semibold text-blue-800">Buat Pabrik</h3>
                        <p class="mt-2 text-sm text-gray-600">Buat pabrik baru dan otomatis menjadi admin. Isi detail pabrik lewat form pembuatan.</p>
                        <div class="mt-4">
                            <span class="inline-block px-3 py-1 text-xs bg-blue-200 text-blue-800 rounded-full">Jadi admin pabrik</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- Footer -->
    <footer class="mt-10 text-gray-500 text-sm">
        &copy; {{ date('Y') }} Pabrik Chan. All rights reserved.
    </footer>
</div>
@endsection