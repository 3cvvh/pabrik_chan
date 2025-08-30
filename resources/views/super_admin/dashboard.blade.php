@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto">
        <div class="mb-10 text-center sm:text-left">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Dashboard Super Admin</h1>
            <p class="text-gray-600 text-lg">Selamat datang di panel kontrol utama</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Card Pabrik -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-50 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-blue-600">{{ $pabrik }}</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Total Pabrik</h3>
                <p class="text-gray-500 text-sm mt-1">Jumlah pabrik yang terdaftar</p>
            </div>

            <!-- Card Admin -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-50 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-green-600">{{ $admin }}</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Total Admin</h3>
                <p class="text-gray-500 text-sm mt-1">Jumlah admin aktif</p>
            </div>

            <!-- Card Owner -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-purple-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-purple-50 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-purple-600">{{ $owner }}</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Total Owner</h3>
                <p class="text-gray-500 text-sm mt-1">Jumlah pemilik pabrik</p>
            </div>

            <!-- Card Orang Gudang -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-amber-200 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-amber-50 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-amber-600">{{ $orang_gudang }}</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Staff Gudang</h3>
                <p class="text-gray-500 text-sm mt-1">Jumlah staff gudang aktif</p>
            </div>
        </div>
    </div>
</div>
@endsection
