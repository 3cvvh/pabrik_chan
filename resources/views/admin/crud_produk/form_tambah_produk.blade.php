@extends('layout.main')
@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-2 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto animate-fadeIn">
        <!-- Card Header with animation -->
        <div class="mb-6 transform transition-all duration-500 animate-slideDown">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900">Tambah Produk Baru</h2>
            <p class="mt-1 text-sm md:text-base text-gray-600">Silahkan isi data produk dengan lengkap</p>
        </div>

        <!-- Main Card with hover effect and animation -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-500 hover:shadow-3xl animate-slideUp">
            <div class="p-4 sm:p-8">
                <form action="{{ Auth::user()->role_id == 1 ? route('produk.store') : route('crud_produk.store') }}" id="create-form" method="post" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <!-- Nama Produk Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 100ms">
                            <label for="nama" class="block text-sm md:text-base font-semibold text-gray-700">Nama Produk</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input value="{{ old('nama') }}" type="text" name="nama" id="nama" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" placeholder="Masukkan nama produk">
                            </div>
                            @error('nama')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga Input (diganti menjadi harga_jual dan harga_modal yang lebih mudah diisi) -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 200ms">
                            <label class="block text-sm md:text-base font-semibold text-gray-700">Harga Jual</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <!-- visible formatted input -->
                                <input type="text" id="harga_jual_display" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 py-3 text-sm md:text-base border-gray-300 rounded-lg" placeholder="0" inputmode="numeric" value="{{ old('harga_jual') ? number_format(old('harga_jual'), 0, ',', '.') : '' }}">
                                <!-- hidden numeric input yang dikirim ke server -->
                                <input type="hidden" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') ?? '' }}">

                            </div>
                            @error('harga_jual')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 250ms">
                            <label class="block text-sm md:text-base font-semibold text-gray-700">Harga Modal</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <!-- visible formatted input -->
                                <input type="text" id="harga_modal_display" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 py-3 text-sm md:text-base border-gray-300 rounded-lg" placeholder="0" inputmode="numeric" value="{{ old('harga_modal') ? number_format(old('harga_modal'), 0, ',', '.') : '' }}">
                                <!-- hidden numeric input yang dikirim ke server -->
                                <input type="hidden" name="harga_modal" id="harga_modal" value="{{ old('harga_modal') ?? '' }}">
                            </div>
                            @error('harga_modal')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn col-span-1 md:col-span-2" style="animation-delay: 300ms">
                            <label for="deskripsi" class="block text-sm md:text-base font-semibold text-gray-700">Deskripsi</label>
                            <div class="mt-1">
                                <textarea id="deskripsi" name="deskripsi" rows="3" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                            </div>
                            @error('deskripsi')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Gambar Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 500ms">
                            <label for="gambar" class="block text-sm md:text-base font-semibold text-gray-700">Gambar Produk</label>
                            <div class="mt-1">
                                <input type="file" name="gambar" id="gambar" accept="image/*" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-2 px-4 text-sm md:text-base border-gray-300 rounded-lg">
                            </div>
                            @error('gambar')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ID Pabrik Select -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 600ms">
                          @foreach ( $pabrik as $id )
                            <input type="hidden" name="id_pabrik" value="{{ $id->id }}">
                            @endforeach
                        </div>

                        <!-- Gudang Select -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 650ms">
                            <label for="gudang" class="block text-sm md:text-base font-semibold text-gray-700">Pilih Gudang</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <select name="id_gudang" id="gudang" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 pl-3 pr-10 text-sm md:text-base border-gray-300 rounded-lg appearance-none">
                                    <option value="">{{ __('Pilih gudang...') }}</option>
                                    @if(isset($gudangs) && $gudangs->count())
                                        @foreach($gudangs as $g)
                                            <option value="{{ $g->id }}" {{ (string)old('id_gudang') === (string)$g->id ? 'selected' : '' }}>
                                                {{ $g->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('id_gudang')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Action Buttons with enhanced animations -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4 pt-6 border-t animate-fadeIn" style="animation-delay: 700ms">
                        <a href="{{ route('produk.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-sm md:text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali
                        </a>
                        <button onclick="confirmCreate()" type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm md:text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-fadeIn {
        animation: fadeIn 0.6s ease-out forwards;
    }
    .animate-slideDown {
        animation: slideDown 0.6s ease-out forwards;
    }
    .animate-slideUp {
        animation: slideUp 0.6s ease-out forwards;
    }
</style>

<script>
function confirmCreate() {
    // sinkronkan nilai terformat ke input tersembunyi sebelum konfirmasi/submit
    syncCurrencyInputs();
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda akan menambahkan produk baru",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, tambah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('create-form').submit();
        }
    })
}
@if(session('jumlah'))
    Swal.fire({
        icon: 'error',
        title: 'gagal',
        text: '{{ session('jumlah') }}',
        timer: 1500,
        showConfirmButton: false
    });
@endif
</script>

<script>
// Utility: hapus semua kecuali digit
function unformatNumber(str){
    if(!str) return '';
    return str.toString().replace(/[^0-9]/g,'');
}

// format angka ke pemisah ribuan lokal (tanpa desimal)
function formatNumberDisplay(val){
    if(val === '') return '';
    return Number(val).toLocaleString('id-ID');
}

function syncCurrencyInputs(){
    // ambil dari display, ubah ke numeric, dan set ke hidden input
    const displayJual = document.getElementById('harga_jual_display');
    const hiddenJual = document.getElementById('harga_jual');
    const displayModal = document.getElementById('harga_modal_display');
    const hiddenModal = document.getElementById('harga_modal');
    if(displayJual && hiddenJual){
        hiddenJual.value = unformatNumber(displayJual.value);
    }
    if(displayModal && hiddenModal){
        hiddenModal.value = unformatNumber(displayModal.value);
    }
}

// formatting saat mengetik
document.addEventListener('DOMContentLoaded', function(){
    const jual = document.getElementById('harga_jual_display');
    const modal = document.getElementById('harga_modal_display');
    if(jual){
        jual.addEventListener('input', function(e){
            const raw = unformatNumber(e.target.value);
            e.target.value = formatNumberDisplay(raw);
        });
        // saat kehilangan fokus, pastikan sinkron
        jual.addEventListener('blur', syncCurrencyInputs);
    }
    if(modal){
        modal.addEventListener('input', function(e){
            const raw = unformatNumber(e.target.value);
            e.target.value = formatNumberDisplay(raw);
        });
        modal.addEventListener('blur', syncCurrencyInputs);
    }
    // pastikan saat submit form normal nilai tersinkron
    const form = document.getElementById('create-form');
    if(form){
        form.addEventListener('submit', function(){ syncCurrencyInputs(); });
    }
});
</script>
@endsection
