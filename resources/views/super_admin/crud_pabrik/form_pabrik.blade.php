@extends('layout.main')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-8 px-2 sm:px-6 lg:px-8">
    <div class="max-w-xl mx-auto animate-fadeIn">
        <!-- Back button -->
        <div class="mb-6 flex items-center">
        </div>
        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 animate-slideUp">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-6">Form Data Pabrik</h2>
            <form action="/dashboard/super_admin/crud_pabrik" method="post" class="space-y-6" enctype="multipart/form-data" id="create-form">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pabrik</label>
                    <input type="text" name="name" id="name"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-sm"
                        placeholder="Masukkan nama pabrik">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <input type="text" name="alamat" id="alamat"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-sm"
                        placeholder="Masukkan alamat pabrik">
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
                    <input type="number" name="no_telepon" id="no_telepon"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-sm"
                        placeholder="Masukkan nomor telepon">
                    @error('no_telepon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="gambar" class="block text-gray-700 text-sm font-medium mb-2">Logo</label>
                    <input type="file" id="gambar" name="gambar" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300">
                    @error('gambar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4 pt-6 border-t">
                    <a href="/dashboard/super_admin/crud_pabrik"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Kembali
                    </a>
                    <button type="button" onclick="confirmCreate()"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Tambahkan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.animate-fadeIn { animation: fadeIn 0.6s ease-out forwards; }
.animate-slideUp { animation: slideUp 0.6s ease-out forwards; }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmCreate() {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data pabrik akan ditambahkan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, tambahkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('create-form').submit();
        }
    })
}
</script>
@endsection
