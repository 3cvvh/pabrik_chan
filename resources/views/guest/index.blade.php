@extends("layout.main")
@section("content")
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200">
    <div class="relative max-w-3xl w-full bg-green-200 p-8 rounded-2xl shadow-lg text-center">
        @auth
        <form method="POST" action="{{ route('logout') }}" class="absolute top-4 right-4">
            @csrf
            <button type="submit" class="px-3 py-1 bg-white text-green-600 rounded-md border border-green-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-200">
                Logout
            </button>
        </form>
        @endauth

        <h1 class="text-4xl font-bold text-gray-900 mb-4">Selamat datang di Pabrik Chan</h1>
        <p class="text-lg text-gray-700 mb-6">
            Jelajahi situs pabrik kami.
        </p>

        <!-- Dua kartu interaktif: Ajukan Bergabung & Buat Pabrik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
            <a href=""
               class="group block bg-white rounded-xl p-6 shadow-md border border-transparent hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-green-200"
               aria-label="Ajukan Bergabung ke Pabrik">
                <div class="flex items-start gap-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0 bg-green-50 rounded-lg p-3 text-green-600 group-hover:bg-green-100">
                        <!-- users icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-1a4 4 0 00-3-3.87M9 20H4v-1a4 4 0 013-3.87M16 11a4 4 0 10-8 0 4 4 0 008 0z"/>
                        </svg>
                    </div>

                    <div class="text-left">
                        <h3 class="text-lg font-semibold text-gray-900">Ajukan Bergabung</h3>
                        <p class="mt-1 text-sm text-gray-600">Pilih pabrik yang ingin Anda masuki dan kirim permohonan. Tunggu konfirmasi dari admin pabrik.</p>
                        <div class="mt-4">
                            <span class="inline-block px-3 py-1 text-sm bg-green-50 text-green-700 rounded-full">Masuk ke pabrik yang ada</span>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('guest.form_pabrik') }}"
               class="group block bg-white rounded-xl p-6 shadow-md border border-transparent hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-green-200"
               aria-label="Buat Pabrik Baru">
                <div class="flex items-start gap-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0 bg-green-50 rounded-lg p-3 text-green-600 group-hover:bg-green-100">
                        <!-- building icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 21h18M5 21V10l7-5 7 5v11M9 21V10m6 11V10" />
                        </svg>
                    </div>

                    <div class="text-left">
                        <h3 class="text-lg font-semibold text-gray-900">Buat Pabrik</h3>
                        <p class="mt-1 text-sm text-gray-600">Buat pabrik baru dan otomatis menjadi admin. Isi detail pabrik lewat form pembuatan.</p>
                        <div class="mt-4">
                            <span class="inline-block px-3 py-1 text-sm bg-green-50 text-green-700 rounded-full">Jadi admin pabrik</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
