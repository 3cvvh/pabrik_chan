@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Admin</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow p-6 flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold">120</div>
                    <div class="text-gray-500">Total Users</div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow p-6 flex items-center">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2v-7a2 2 0 00-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold">45</div>
                    <div class="text-gray-500">Orders Today</div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow p-6 flex items-center">
                <div class="bg-yellow-100 p-3 rounded-full mr-4">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3"></path>
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold">Rp 15.000.000</div>
                    <div class="text-gray-500">Pendapatan Bulan Ini</div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
