@extends('layout.main')
@section('content')

<div class="bg-gradient-to-b from-blue-50 to-white">
    <x-navbar></x-navbar>
    <div class="container mx-auto px-4 py-16">
      <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Mulai Perjalanan Anda</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Kelola pabrik Anda dengan lebih efisien menggunakan sistem manajemen kami
            </p>
        </div>

        <!-- Pricing Card -->
        <div class="max-w-md mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 bg-blue-600 text-white">
                <h2 class="text-2xl font-semibold">Berlangganan</h2>
                <p class="opacity-90">30 hari akses penuh</p>
            </div>

            <div class="p-8">
                <!-- Benefits List -->
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Akses ke semua fitur
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Efisiensi operasional maksimal
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Mulai dari 94.000 IDR/bulan
                    </li>
                </ul>
                <!-- form berlangganan -->
                <button id="pay-button"  class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold
                            hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Mulai Berlangganan
                    </button>
            </div>
        </div>
    </div>
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key={{ config('midtrans.client_key') }}></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            window.location.href = "{{ route('berhasil.payment') }}";
          },
          // Optional
          onPending: function(result){

          },
          // Optional
          onError: function(result){
            window.location.href = "{{ route('gagal.payment') }}";
          }
        });
      };
    </script>
@endsection
