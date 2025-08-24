@extends('layout.main')
@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto animate-fadeIn">
        <!-- Card Header with animation -->
        <div class="mb-6 transform transition-all duration-500 animate-slideDown">
            <h2 class="text-3xl font-extrabold text-gray-900">Tambah Produk Baru</h2>
            <p class="mt-1 text-sm text-gray-600">Silahkan isi data produk dengan lengkap</p>
        </div>

        <!-- Main Card with hover effect and animation -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-500 hover:shadow-3xl animate-slideUp">
            <div class="p-8">
                <form action="{{ Auth::user()->role_id == 1 ? route('produk.store') : route('crud_produk.store') }}" id="create-form" method="post" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Produk Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 100ms">
                            <label for="nama" class="block text-sm font-semibold text-gray-700">Nama Produk</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input value="{{ old('nama') }}" type="text" name="nama" id="nama" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm border-gray-300 rounded-lg" placeholder="Masukkan nama produk">
                            </div>
                            @error('nama')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 200ms">
                            <label for="harga" class="block text-sm font-semibold text-gray-700">Harga</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="harga" id="harga" value="{{ old('harga') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 py-3 text-sm border-gray-300 rounded-lg" placeholder="0">
                            </div>
                            @error('harga')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn col-span-2" style="animation-delay: 300ms">
                            <label for="deskripsi" class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                            <div class="mt-1">
                                <textarea id="deskripsi" name="deskripsi" rows="3" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm border-gray-300 rounded-lg" placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                            </div>
                            @error('deskripsi')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Gambar Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 500ms">
                            <label for="gambar" class="block text-sm font-semibold text-gray-700">Gambar Produk</label>
                            <div class="mt-1">
                                <input type="file" name="gambar" id="gambar" accept="image/*" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-2 px-4 text-sm border-gray-300 rounded-lg">
                            </div>
                            @error('gambar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ID Pabrik Select -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 600ms">
                          @foreach ( $pabrik as $id )
                            <input type="hidden" name="id_pabrik" value="{{ $id->id }}">
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons with enhanced animations -->
                    <div class="flex justify-end space-x-4 pt-6 border-t animate-fadeIn" style="animation-delay: 700ms">
                        <a href="{{ route('produk.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali
                        </a>
                        <button onclick="confirmCreate()" type="button" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
@endsection
