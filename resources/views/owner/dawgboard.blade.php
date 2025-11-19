@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
@php
    // Formatter singkat untuk IDR: 2rb, 2,5rb, 2jt, dst.
    $formatIDRShort = function($n) {
        $n = (float) ($n ?? 0);
        if ($n == 0) {
            return 'Rp 0';
        }
        $abs = abs($n);
        if ($abs >= 1000000) {
            // juta -> jt
            $val = number_format($n / 1000000, ($abs % 1000000 === 0) ? 0 : 1, ',', '');
            return 'Rp ' . $val . 'jt';
        } elseif ($abs >= 1000) {
            // ribu -> rb
            $val = number_format($n / 1000, ($abs % 1000 === 0) ? 0 : 1, ',', '');
            return 'Rp ' . $val . 'rb';
        } else {
            // kurang dari 1000 tampilkan utuh tanpa desimal
            return 'Rp ' . number_format($n, 0, ',', '.');
        }
    };
@endphp

<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Owner</h1>
            <p class="text-gray-600">Selamat datang di halaman dashboard.</p>
        </div>

        <!-- FILTER TANGGAL -->
        @if (Auth::user()->pabrik->Ispaid == true)
        <div class="mb-6">
            <form method="GET" action="" class="flex flex-col md:flex-row items-start md:items-end gap-4">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400">
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400">
                </div>
                <div class="pt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
                </div>
                @if(request('tanggal_mulai') || request('tanggal_selesai'))
                    <div class="pt-6">
                        <a href="{{ url()->current() }}" class="px-3 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">Reset</a>
                    </div>
                @endif
            </form>
        </div>
        <!-- END FILTER TANGGAL -->

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

        <!-- NEW: Total Pendapatan Bersih & Per-Produk -->
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Total Pendapatan Bersih</h2>
                        <p class="text-sm text-gray-500">Menghitung (harga_satuan - harga_modal) * jumlah, hanya transaksi selesai</p>
                    </div>
                    <div class="text-2xl font-extrabold text-green-600">
                        {{ $formatIDRShort($totalNet ?? 0) }}
                    </div>
                </div>

                <div class="mt-4">
                    <h3 class="text-md font-medium text-gray-700">Pendapatan per Produk</h3>
                    <div class="mt-3 space-y-2 max-h-56 overflow-y-auto pr-2">
                        @if(!empty($productNets) && $productNets->count() > 0)
                            @foreach($productNets as $p)
                                <div class="flex justify-between items-center bg-gray-50 rounded p-3 border">
                                    <div class="text-gray-700">{{ $p->nama }}</div>
                                    <div class="text-sm font-semibold text-gray-800">{{ $formatIDRShort($p->net ?? 0) }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-sm text-gray-500">Belum ada pendapatan tercatat.</div>
                        @endif
                    </div>

                    {{-- ADDED: Chart canvas for product profits --}}
                    @if(!empty($productNets) && $productNets->count() > 0)
                        <div class="mt-6 bg-white rounded p-4 border">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Grafik Keuntungan per Produk</h4>
                            <div class="w-full overflow-x-auto">
                                <canvas id="profitChart" style="max-height:300px;"></canvas>
                            </div>
                        </div>
                    @endif

                    {{-- NEW: Keuntungan per Gudang --}}
                    <div class="mt-6">
                        <h3 class="text-md font-medium text-gray-700">Keuntungan per Gudang</h3>
                        <div class="mt-3 space-y-2 max-h-56 overflow-y-auto pr-2">
                            @if(!empty($gudangNets) && $gudangNets->count() > 0)
                                @foreach($gudangNets as $g)
                                    <div class="flex justify-between items-center bg-gray-50 rounded p-3 border">
                                        <div class="text-gray-700">{{ $g->nama }}</div>
                                        <div class="text-sm font-semibold text-gray-800">{{ $formatIDRShort($g->net ?? 0) }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-sm text-gray-500">Belum ada keuntungan per gudang tercatat.</div>
                            @endif
                        </div>

                        @if(!empty($gudangNets) && $gudangNets->count() > 0)
                            <div class="mt-4 bg-white rounded p-4 border">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Grafik Keuntungan per Gudang</h4>
                                <div class="w-full overflow-x-auto">
                                    <canvas id="warehouseChart" style="max-height:300px;"></canvas>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END NEW -->
        @else
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-lg max-w-3xl mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-2">Peringatan Pembayaran</h2>
        <p class="mb-4">Pabrik belum bisa megunakan semua fitur karna belum berlangganan</p>
    </div>
        @endif

    </div>
</div>

{{-- ADDED: Chart.js and rendering script (only when product or gudang data exists) --}}
@if((!empty($productNets) && $productNets->count() > 0) || (!empty($gudangNets) && $gudangNets->count() > 0))
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        (function(){
            const formatIDRCurrency = (v) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(v);

            // PRODUCT DATA (may be undefined)
            const productLabels = {!! json_encode(!empty($productNets) ? $productNets->pluck('nama') : []) !!};
            const productValues = {!! json_encode(!empty($productNets) ? $productNets->pluck('net') : []) !!};

            // GUDANG DATA (may be undefined)
            const warehouseLabels = {!! json_encode(!empty($gudangNets) ? $gudangNets->pluck('nama') : []) !!};
            const warehouseValues = {!! json_encode(!empty($gudangNets) ? $gudangNets->pluck('net') : []) !!};

            document.addEventListener('DOMContentLoaded', function () {
                // Product chart
                const profitCanvas = document.getElementById('profitChart');
                if (profitCanvas && productLabels.length > 0) {
                    const ctx = profitCanvas.getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: productLabels,
                            datasets: [{
                                label: 'Keuntungan (IDR)',
                                data: productValues,
                                backgroundColor: 'rgba(59,130,246,0.6)',
                                borderColor: 'rgba(59,130,246,1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    ticks: {
                                        callback: function(value) { return formatIDRCurrency(value); }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const v = context.parsed.y ?? context.parsed;
                                            return 'Keuntungan: ' + formatIDRCurrency(v);
                                        }
                                    }
                                },
                                legend: { display: false }
                            }
                        }
                    });
                }

                // Warehouse chart
                const warehouseCanvas = document.getElementById('warehouseChart');
                if (warehouseCanvas && warehouseLabels.length > 0) {
                    const ctx2 = warehouseCanvas.getContext('2d');
                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: warehouseLabels,
                            datasets: [{
                                label: 'Keuntungan per Gudang (IDR)',
                                data: warehouseValues,
                                backgroundColor: 'rgba(16,185,129,0.6)',
                                borderColor: 'rgba(16,185,129,1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    ticks: {
                                        callback: function(value) { return formatIDRCurrency(value); }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const v = context.parsed.y ?? context.parsed;
                                            return 'Keuntungan: ' + formatIDRCurrency(v);
                                        }
                                    }
                                },
                                legend: { display: false }
                            }
                        }
                    });
                }
            });
        })();

    </script>
@endif
<script>
     <x-alert></x-alert>
</script>
@endsection
