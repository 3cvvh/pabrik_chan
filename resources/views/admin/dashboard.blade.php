@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Admin</h1>
        @if (!Auth::user()->pabrik->Ispaid )
        <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
            <p class="font-semibold">Peringatan:</p>
            <p>Anda belum melakukan pembayaran untuk pabrik Anda. Silakan lakukan pembayaran segera agar dapat mengakses semua fitur.</p>
            <a href="{{ route('payment.index') }}" class="inline-block mt-2 px-4 py-2 bg-yellow-500 text-white font-semibold rounded hover:bg-yellow-600 transition">
                Lakukan Pembayaran
            </a>
        </div>
        @else
        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Users</span>
                </div>
                <div class="text-2xl font-bold">{{ $user }}</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Products</span>
                </div>
                <div class="text-2xl font-bold">{{ $produk }}</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Transactions</span>
                </div>
                <div class="text-2xl font-bold">{{ $transaksi }}</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Stock Overview</h2>
                <canvas id="stockChart"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Transaction History</h2>
                <canvas id="transactionChart"></canvas>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 mb-2">Total Stock</div>
                <div class="text-2xl font-bold">{{ $total_stock }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 mb-2">Total Buyers</div>
                <div class="text-2xl font-bold">{{ $pembeli }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 mb-2">Warehouses</div>
                <div class="text-2xl font-bold">{{ $gudang }}</div>
            </div>
        </div>
    </div>
</div>
 @endif
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Stock Chart
    const stockCtx = document.getElementById('stockChart').getContext('2d');
    new Chart(stockCtx, {
        type: 'bar',
        data: {
            labels: ['Total Stock', 'Products', 'Warehouses'],
            datasets: [{
                label: 'Inventory Overview',
                data: [{{ $total_stock }}, {{ $produk }}, {{ $gudang }}],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Transaction Chart
    const transactionCtx = document.getElementById('transactionChart').getContext('2d');
    new Chart(transactionCtx, {
        type: 'line',
        data: {
            labels: ['Users', 'Buyers', 'Transactions'],
            datasets: [{
                label: 'Business Overview',
                data: [{{ $user }}, {{ $pembeli }}, {{ $transaksi }}],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


</script>
@endsection
