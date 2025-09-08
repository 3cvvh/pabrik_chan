@extends('layout.main')
@section('content')

<div class="min-h-screen bg-gray-100 py-8 px-2 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto animate-fadeIn">
        <!-- Card Header with animation -->
        <div class="mb-6 transform transition-all duration-500 animate-slideDown">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900">Tambah Pembeli</h2>
            <p class="mt-1 text-sm md:text-base text-gray-600">Silahkan isi data pembeli dengan lengkap</p>
        </div>

        <!-- Main Card with hover effect and animation -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-500 hover:shadow-3xl animate-slideUp">
            <div class="p-4 sm:p-8">
                <form id="create-form" action="/dashboard/admin/crud_pembeli" method="post" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 100ms">
                            <label for="id_pabrik" class="block text-sm md:text-base font-semibold text-gray-700">Pabrik</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input name="id_pabrik" id="id_pabrik" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" value="{{ $pabrik->name }}" readonly>
                                <input type="hidden" name="id_pabrik" value="{{ $pabrik->id }}">
                            </div>
                            @error('id_pabrik')
                                <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 200ms">
                            <label for="name" class="block text-sm md:text-base font-semibold text-gray-700">Nama Pembeli</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="name" id="name" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" placeholder="Masukkan nama pembeli">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 300ms">
                            <label for="alamat" class="block text-sm md:text-base font-semibold text-gray-700">Alamat</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="alamat" id="alamat" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" placeholder="Masukkan alamat pembeli">
                            </div>
                            @error('alamat')
                                <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 400ms">
                            <label for="no_telepon" class="block text-sm md:text-base font-semibold text-gray-700">No Telepon</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="no_telepon" id="no_telepon" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" placeholder="Masukkan nomor telepon pembeli">
                            </div>
                            @error('no_telepon')
                                <p class="mt-2 text-sm md:text-base text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4 pt-6 border-t animate-fadeIn" style="animation-delay: 700ms">
                        <a href="/dashboard/admin/crud_pembeli" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm md:text-base border border-gray-300 shadow-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali
                        </a>
                        <button onclick="confirmPembeli(this)" type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm md:text-base border border-transparent font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Pembeli
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
function confirmPembeli(button) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "akan menambahkan data pembeli",
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
    });
}
</script>
@endsection
