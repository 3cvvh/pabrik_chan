@extends('layout.main')
@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ Auth::user()->role_id == 1 ? route('crud_transaksi.index') : route('owner.index') }}" class="text-gray-700 hover:text-blue-600 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-gray-500 ml-1 md:ml-2 font-medium">Detail Transaksi</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Transaction Header -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="border-b border-gray-200 px-8 py-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-800">{{ $data_transaksi->judul }}</h1>
                <div class="flex items-center space-x-3">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold inline-flex items-center
                        @if($data_transaksi->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($data_transaksi->status == 'completed') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        <span class="w-2 h-2 rounded-full mr-2
                            @if($data_transaksi->status == 'pending') bg-yellow-400
                            @elseif($data_transaksi->status == 'completed') bg-green-400
                            @else bg-gray-400
                            @endif"></span>
                        {{ $data_transaksi->status }}
                    </span>

                    <button type="button"
                        onclick="confirmGenerate('{{ Auth::user()->role_id == 1 ? route('admin.laporan', $data_transaksi->id) : route('owner.laporan',$data_transaksi->id) }}')"
                        class="px-3 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Generate Laporan
                    </button>
                </div>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pabrik</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->pabrik->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pembeli</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->pembeli->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Tanggal Transaksi</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->tanggal_transaksi ?? 'belum dikirim' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Tanggal Pengiriman</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->tanggal_pengiriman ?? 'belum dikirim' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg col-span-2">
                            <p class="text-sm text-gray-500">Tanggal Pembayaran</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $data_transaksi->tanggal_pembayaran ?? 'belum dibayar' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="mt-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Detail Produk
            </h3>

            @if(Auth::user()->role_id == 1 && $data_transaksi->status != 'completed')
                @php
                    $produk_stok_ada = $dataproduk->filter(function($item) {
                        return $item->stock && $item->stock->sum('jumlah') > 0;
                    })->count();
                @endphp
                @if(!$data_detail->isEmpty() && $produk_stok_ada > 0)
                    <button type="button" onclick="document.getElementById('form-tambah-produk').classList.remove('hidden')" class="flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                        </svg>
                        Tambah Produk
                    </button>
                @endif
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if($data_detail->isEmpty())
                <div class="col-span-3 flex flex-col items-center justify-center py-12 bg-gray-50 rounded-lg shadow-inner">
                    <div class="mb-4">
                        <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="20" stroke-width="2" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 24h16M24 16v16" />
                        </svg>
                    </div>
                    <p class="text-lg text-gray-600 mb-2 font-semibold">
                        Belum ada produk dalam transaksi ini
                    </p>
                    <p class="text-gray-500 mb-6">
                        Silakan tambahkan produk ke transaksi dengan memilih produk di bawah ini.
                    </p>
                    <form action="{{ route('admin.produk', $data_transaksi->id) }}"
                          method="post"
                          id="form-tambah-product"
                          class="w-full max-w-md">
                        @csrf
                        <input type="hidden" name="id_tran" value="{{ $data_transaksi->id }}">
                        <div class="border rounded-md p-3 space-y-1 hover:border-gray-400 transition-colors bg-white">
                            @if($dataproduk->isEmpty() || $dataproduk->where('stock','!=',null)->sum(fn($p)=>$p->stock->sum('jumlah')) <= 0)
                                <h1 class="text-red-500 font-semibold text-center">
                                    Stok produk tidak tersedia
                                </h1>
                            @else
                                @foreach ($dataproduk as $item)
                                    @if($item->stock && $item->stock->sum('jumlah') > 0)
                                        <div class="flex items-center p-2 rounded-md hover:bg-gray-50 transition-colors cursor-pointer gap-3">
                                            <input type="checkbox"
                                                   name="id_produk[]"
                                                   value="{{ $item->id }}"
                                                   class="w-4 h-4 border-gray-300 rounded text-blue-500 transition-colors">
                                            <span class="ml-2 select-none">
                                                {{ $item->nama }}
                                            </span>
                                            <span class="ml-2">
                                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                    Stok: {{ $item->total_stock  ?? 0 }}
                                                </span>
                                            </span>
                                            <input type="number"
                                                   name="jumlah[{{ $item->id }}]"
                                                   min="0"
                                                   max="{{ $item->stock->sum('jumlah') }}"
                                                   value="0"
                                                   class="w-14 text-center border rounded ml-auto">
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button"
                                    onclick="confirmTambahProduk(this)"
                                    class="flex items-center px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                                </svg>
                                Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Loop detail produk (tampilkan semua produk relasi, stok berapapun) --}}
            @foreach ($data_detail as $data)
                @if($data->produk)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 relative
                        @if($data->produk->stock->sum('jumlah') <= 0) border-2 border-red-400 @endif">
                        @if($data->produk->gambar == null)
                            <div class="bg-gray-200 h-48 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @else
                            <img src="{{ asset('storage/'. $data->produk->gambar ) }}"
                                 alt="{{ $data->produk->nama }}"
                                 class="w-full h-48 object-cover">
                        @endif

                        @if(Auth::user()->role_id == 1 && $data_transaksi->status != 'completed')
                            <form action="{{ route('admin-hapus',$data->id) }}" method="POST" class="absolute top-2 right-2" onsubmit="return confirmHapusProduk(event, this)">
                                @csrf
                                <input type="hidden" name="id_tran" value="{{ $data->transaksi->id }}">
                                <button type="submit" class="p-2 rounded-full bg-red-100 hover:bg-red-200 text-red-600" title="Hapus Produk">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        @endif

                        <div class="p-6">
                            <h4 class="font-semibold text-lg text-gray-800 mb-2">{{ $data->produk->nama }}</h4>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-600">Jumlah</p>
                                    <p class="font-semibold text-lg">{{ $data->jumlah }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-600">Total</p>
                                    <p class="font-bold text-lg text-blue-600">Rp {{ number_format($data->total_harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            {{-- Peringatan stok habis --}}
                            @if($data->produk->stock->sum('jumlah') <= 0)
                                <div class="mt-4 p-2 bg-red-100 rounded text-red-700 text-sm font-semibold flex items-center gap-2">
                            <!-- Ikon silang -->
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                                Stok produk ini sudah habis!
                            </div>
                            @else
                                <div class="mt-4 p-2 bg-green-100 rounded text-green-700 text-sm font-semibold flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                    </svg>
                                    Stok tersedia: {{ $data->produk->stock->sum('jumlah') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Modal/Form Tambah Produk (hidden by default) --}}
        @if(Auth::user()->role_id == 1)
            <div id="form-tambah-produk" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
                    <button type="button" onclick="document.getElementById('form-tambah-produk').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <form action="{{ route('admin.produk', $data_transaksi->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="id_tran" value="{{ $data_transaksi->id }}">
                        <h4 class="font-bold mb-4">Tambah Produk ke Transaksi</h4>
                        <div class="border rounded-md p-3 space-y-1 max-h-60 overflow-y-auto">
                            @foreach ($dataproduk as $item)
                                @if( $item->stock && $item->stock->sum('jumlah') > 0 )
                                    <div class="flex items-center p-2 rounded-md hover:bg-gray-50 transition-colors cursor-pointer gap-3">
                                        <input type="checkbox" name="id_produk[]" value="{{ $item->id }}"
                                            class="w-4 h-4 border-gray-300 rounded text-blue-500 transition-colors">
                                        <span class="ml-2 select-none">{{ $item->nama }}</span>
                                        <span class="ml-2">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                Stok: {{ $item->total_stock  ?? 0 }}
                                            </span>
                                        </span>
                                        <input type="number" min="0" name="jumlah[{{ $item->id }}]"
                                            class="w-14 text-center border rounded ml-auto"
                                            placeholder="0">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @error('id_produk')
                        <span class="text-red-500 text-sm mt-1 animate-fade-in">{{ $message }}</span>
                        @enderror
                        <div class="flex justify-end mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- Form Update Section -->
    @if(Auth::user()->role_id == 1)
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Update Tanggal
            </h3>

            <form action="{{ route('admin.tanggal',$data_transaksi->id) }}" id="form-tgl" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="id" value="{{ $data_transaksi->id }}">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Tanggal Pengiriman</label>
                        <input type="date" value="{{ $data_transaksi->tanggal_pengiriman }}" name="tanggal_pengiriman" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                        <input type="date" value="{{ $data_transaksi->tanggal_pembayaran }}" name="tanggal_pembayaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="confirmtgl(this)" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                    <a href="{{ route('crud_transaksi.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">Batal</a>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
<script>
    @if(session('gagal'))
    Swal.fire({
        icon: 'warning',
        title: 'gagal',
        text: '{{ session('gagal') }}',
        timer: 1500,
        showConfirmButton: false
    });
    @endif
    @if(session('berhasil'))
    Swal.fire({
        icon: 'success',
        title: 'berhasil',
        text: '{{ session('berhasil') }}',
        timer: 1500,
        showConfirmButton: false
    });
    @endif

    function confirmTambahProduk(button) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "akan menambahkan data produk ini ke transaksi?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, tambah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
    function confirmtgl(button) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "akan menambahkan data tanggal ini ke transaksi?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, tambah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    function confirmHapusProduk(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Produk akan dihapus dari transaksi ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }

    function confirmGenerate(url) {
        Swal.fire({
            title: 'Generate Laporan?',
            text: "Laporan transaksi akan dibuka di tab baru.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, generate',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open(url, '_blank');
            }
        });
    }
</script>
@endsection