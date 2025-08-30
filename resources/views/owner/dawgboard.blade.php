@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Owner</h1>
            <p class="text-gray-600">Selamat datang di halaman dashboard.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-blue-500 text-4xl mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4M3 17l9 4 9-4"/>
                    </svg>
                </div>
                <div class="text-lg font-semibold text-gray-700">Gudang</div>
                <div class="text-2xl font-bold text-gray-900">{{ $gudang }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-green-500 text-4xl mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.304.534 6.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="text-lg font-semibold text-gray-700">Admin</div>
                <div class="text-2xl font-bold text-gray-900">{{ $admin }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-yellow-500 text-4xl mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"/>
                    </svg>
                </div>
                <div class="text-lg font-semibold text-gray-700">Orang Gudang</div>
                <div class="text-2xl font-bold text-gray-900">{{ $orangGudang }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
