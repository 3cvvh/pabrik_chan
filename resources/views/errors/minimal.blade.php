
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', '404 - Page Not Found')</title>
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/logopabrik.png') }}">
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative min-h-screen flex items-center justify-center
             bg-gradient-to-b from-blue-200 via-blue-50 to-gray-100
             text-gray-800 overflow-hidden">

  <!-- Background Factory Illustration -->
  <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
    <img src="https://i.ibb.co/ygbLxrF/factory-illustration.png"
         alt="Factory Illustration"
         class="w-full max-w-4xl object-contain">
  </div>

  <!-- Animated Smoke -->
  <div class="absolute top-20 left-1/2 transform -translate-x-1/2 flex space-x-4">
    <span class="w-5 h-5 bg-gray-400 rounded-full animate-smoke"></span>
    <span class="w-4 h-4 bg-gray-300 rounded-full animate-smoke delay-200"></span>
    <span class="w-3 h-3 bg-gray-200 rounded-full animate-smoke delay-400"></span>
  </div>

  <!-- Main Content -->
  <div class="relative z-10 text-center p-10 sm:p-14 max-w-lg
              bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl
              border border-gray-200">

    <!-- Logo Gear -->
    <div class="flex justify-center mb-6 relative">
      <svg xmlns="http://www.w3.org/2000/svg"
           class="w-24 h-24 text-blue-700 animate-gear-glow"
           viewBox="0 0 24 24" fill="currentColor">
        <path d="M19.14,12.94c0-.31.05-.61.08-.92l2.11-1.65a.5.5,0,0,0,.12-.64l-2-3.46a.5.5,0,0,0-.6-.22l-2.49,1
        a6.73,6.73,0,0,0-1.6-.92l-.38-2.65A.5.5,0,0,0,13.83,3H10.17a.5.5,0,0,0-.49.42L9.3,6.07a6.59,6.59,0,0,0-1.6.92l-2.49-1
        a.5.5,0,0,0-.6.22l-2,3.46a.5.5,0,0,0,.12.64l2.11,1.65c0,.31-.08.61-.08.92s.05.61.08.92L2.86,15.5a.5.5,0,0,0-.12.64l2,3.46a.5.5,0,0,0,.6.22l2.49-1a6.59,6.59,0,0,0,1.6.92l.38,2.65a.5.5,0,0,0,.49.42h3.66a.5.5,0,0,0,.49-.42l.38-2.65a6.73,6.73,0,0,0,1.6-.92l2.49,1a.5.5,0,0,0,.6-.22l2-3.46a.5.5,0,0,0-.12-.64l-2.11-1.65C19.09,13.55,19.14,13.25,19.14,12.94Z"/>
        <circle cx="12" cy="12" r="3"/>
      </svg>
    </div>

    <!-- Error Code -->
    <h1 class="text-6xl sm:text-7xl font-extrabold text-blue-800 tracking-tight drop-shadow-lg">
      @yield('code', '404')
    </h1>

    <!-- Message -->
    <p class="mt-4 text-lg sm:text-xl font-semibold tracking-wide text-gray-700">
      @yield('message', 'Halaman tidak ditemukan. Mesin pabrik berhenti ⚙️')
    </p>

    <!-- Back Button -->
    <div class="mt-10">
      <a href="{{ url('/') }}"
         class="px-8 py-3 rounded-lg font-bold border border-blue-400
                bg-blue-600 text-white hover:bg-blue-700 hover:scale-105
                focus:ring-4 focus:ring-blue-300
                transition-all shadow-lg text-lg">
        ⬅️ Kembali
      </a>
    </div>

    <!-- Subtext -->
    <p class="mt-6 text-sm text-gray-500 italic">
      “Setiap mesin berhenti, tapi produksi akan berjalan lagi.”
    </p>
  </div>

  <!-- Animations -->
  <style>
    @keyframes smoke {
      0% { transform: translateY(0) scale(1); opacity: 0.6; }
      50% { opacity: 0.4; }
      100% { transform: translateY(-120px) scale(1.6); opacity: 0; }
    }
    .animate-smoke { animation: smoke 7s ease-in-out infinite; }
    .delay-200 { animation-delay: 2s; }
    .delay-400 { animation-delay: 4s; }

    @keyframes gear-glow {
      0%,100% { filter: drop-shadow(0 0 4px rgba(37,99,235,0.6)); }
      50% { filter: drop-shadow(0 0 12px rgba(37,99,235,0.9)); }
    }
    .animate-gear-glow { animation: gear-glow 4s ease-in-out infinite; }
  </style>
</body>
</html>
