@extends('layout.main')
@section('content')

<div class="min-h-screen bg-gray-100 py-8 px-2 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto animate-fadeIn">
        <!-- Card Header with animation -->
        <div class="mb-6 transform transition-all duration-500 animate-slideDown">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900">Edit stok</h2>
            <p class="mt-1 text-sm md:text-base text-gray-600">Silahkan isi data stok dengan lengkap</p>
        </div>

        <!-- Main Card with hover effect and animation -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-500 hover:shadow-3xl animate-slideUp">
            <div class="p-4 sm:p-8">
                <form action="{{ route('Stock_produk.update',$stock->id) }}" id="create-form" method="post" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('put')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <!-- Nama Produk Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 100ms">
                            <label for="nama" class="block text-sm md:text-base font-semibold text-gray-700">Jumlah</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input value="{{ old('jumlah',$stock->jumlah) }}" type="number" name="jumlah" id="nama" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" placeholder="Masukkan jumlah stok">
                            </div>
                            @error('jumlah')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 100ms">
                            <label for="nama" class="block text-sm md:text-base font-semibold text-gray-700">tanggal masuk</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input value="{{ old('tanggal_masuk',$stock->tanggal_masuk) }}" type="date" name="tanggal_masuk" id="nama" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" placeholder="Masukkan jumlah stok">
                            </div>
                            @error('tanggal_masuk')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Keterangan Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn col-span-1 md:col-span-2" style="animation-delay: 300ms">
                            <label for="deskripsi" class="block text-sm md:text-base font-semibold text-gray-700">Keterangan</label>
                            <div class="mt-1">
                                <textarea id="keterangan" name="keterangan" rows="3" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" placeholder="Masukkan keterangan stok">{{ old('keterangan',$stock->keterangan) }}</textarea>
                            </div>
                            @error('deskripsi')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- ID Gudang Select -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 600ms">
                            <label for="id_gudang" class="block text-sm md:text-base font-semibold text-gray-700">Gudang</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <select name="id_gudang" id="id_gudang" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg">
                                    <option value="">Pilih Gudang</option>
                                    @foreach ($gudang as $g)
                                        <option value="{{ $g->id }}" {{ old('id_gudang',$stock->id_gudang) == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_gudang')
                            <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input readonly value="{{ old('jumlah',$stock->produk->nama) }}" type="text" name="" id="nama" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" placeholder="Masukkan jumlah stok">
                        </div>
                    </div>

                    <!-- Action Buttons with enhanced animations -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4 pt-6 border-t animate-fadeIn" style="animation-delay: 700ms">
                        <a href="{{ route('Stock_produk.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-sm md:text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali
                        </a>
                        <button onclick="confirmCreate()" type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm md:text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Edit Stok
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
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda akan mengedit stok",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Edit!',
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
@endsection
