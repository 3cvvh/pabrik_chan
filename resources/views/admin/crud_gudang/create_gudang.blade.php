@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="max-w-3xl mx-auto p-4">
    <div class="bg-white border rounded-lg shadow-lg transform transition-all duration-300 hover:scale-[1.01]">
        <div class="border-b p-4 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-semibold text-xl bg-clip-text text-transparent bg-gradient-to-r from-gray-700 to-gray-900">
                Tambah Gudang
            </h2>
        </div>
        <form action="/dashboard/admin/crud_gudang" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                <div class="group">
                    <label for="id_pabrik" class="block mb-1 text-gray-700 group-hover:text-gray-900 transition-colors">Pabrik</label>
                    <input name="id_pabrik" id="id_pabrik"
                        class="w-full h-10 px-3 border rounded-md transition-all duration-200
                        focus:ring-2 focus:ring-blue-100 focus:border-blue-400 hover:border-gray-400"
                        value="{{ $pabrik->name }}" readonly>
        <input type="hidden" name="id_pabrik" value="{{ $pabrik->id }}">
                </div>
                <div class="group">
                    <label for="nama" class="block mb-1 text-gray-700 group-hover:text-gray-900 transition-colors">Nama Gudang</label>
                    <input type="text" name="nama" id="nama"
                        class="w-full h-10 px-3 border rounded-md transition-all duration-200
                        focus:ring-2 focus:ring-blue-100 focus:border-blue-400 hover:border-gray-400" required>
                </div>
                <div class="group">
                    <label for="alamat" class="block mb-1 text-gray-700 group-hover:text-gray-900 transition-colors">Alamat</label>
                    <input type="text" name="alamat" id="alamat"
                        class="w-full h-10 px-3 border rounded-md transition-all duration-200
                        focus:ring-2 focus:ring-blue-100 focus:border-blue-400 hover:border-gray-400" required>
                </div>
                <div class="group">
                    <label for="no_telepon" class="block mb-1 text-gray-700 group-hover:text-gray-900 transition-colors">No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon"
                        class="w-full h-10 px-3 border rounded-md transition-all duration-200
                        focus:ring-2 focus:ring-blue-100 focus:border-blue-400 hover:border-gray-400">
                </div>
                <div class="group">
                    <label for="keterangan" class="block mb-1 text-gray-700 group-hover:text-gray-900 transition-colors">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="2"
                        class="w-full px-3 py-2 border rounded-md transition-all duration-200
                        focus:ring-2 focus:ring-blue-100 focus:border-blue-400 hover:border-gray-400"></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                <a href="/dashboard/admin/crud_gudang"
                    class="group px-4 py-2 border rounded-lg hover:bg-gray-50 active:bg-gray-100
                    transition-all duration-200 relative overflow-hidden">
                    <span class="relative z-10 font-medium">Batal</span>
                    <div class="absolute inset-0 h-full w-0 bg-gray-100 transition-all duration-300
                        group-hover:w-full"></div>
                </a>
                <button type="button"
                    onclick="confirm(this)"
                    class="relative px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg
                    transition-all duration-200 hover:shadow-lg hover:from-blue-600 hover:to-blue-700
                    active:scale-95 disabled:opacity-75 disabled:cursor-wait"
                    :disabled="loading">
                    <span class="relative z-10 font-medium" x-show="!loading">Simpan</span>
                    <span class="relative z-10 flex items-center" x-show="loading" x-cloak>
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.animate-fade-in {
    animation: fadeIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

[x-cloak] { display: none !important; }

input:focus, select:focus, textarea:focus {
    animation: input-pop 0.2s ease-out;
}

@keyframes input-pop {
    50% { transform: scale(1.02); }
}

input[type="checkbox"] {
    transition: all 0.2s;
}
input[type="checkbox"]:checked {
    animation: checkbox-pop 0.3s ease-out;
}

@keyframes checkbox-pop {
    50% { transform: scale(1.2); }
}
</style>

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
<script>
function confirm(button) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "akan menambahkan data gudang",
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
</script>
@endsection