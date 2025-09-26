@extends('layout.main')
@section('content')

<div class="min-h-screen bg-gray-100 py-8 px-2 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto animate-fadeIn">
        <!-- Card Header with animation -->
        <div class="mb-6 transform transition-all duration-500 animate-slideDown">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 text-center">
                {{ isset($transaksi)? 'Edit Transaksi': 'Tambah Transaksi' }}
            </h2>
            <p class="mt-1 text-sm md:text-base text-gray-600 text-center">Silahkan isi data transaksi dengan lengkap
            </p>
        </div>
        <!-- Main Card with hover effect and animation -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-500 hover:shadow-3xl animate-slideUp">
            <div class="p-4 sm:p-8">
                <form action="{{ isset($transaksi)? route('crud_transaksi.update',$transaksi->id) : route('crud_transaksi.store') }}" id="transaksi-form" method="post" class="space-y-8">
                    @csrf
                    @if(isset($transaksi))
                    @method('put')
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="transform transition-all duration-300 animate-fadeIn col-span-1 md:col-span-2"
                            style="animation-delay: 100ms">
                            <label class="block text-sm md:text-base font-semibold text-gray-700">Nama Transaksi</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" value="{{ old('judul',$transaksi->judul ?? '' ) }}" name="judul"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg">
                            </div>
                            @error('judul')
                            <span class="text-red-500 text-sm mt-1 animate-fade-in">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn col-span-1 md:col-span-2"
                            style="animation-delay: 200ms">
                            <label class="block text-sm md:text-base font-semibold text-gray-700">Pembeli</label>
                            <select name="id_pembeli"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg">
                                <option value="">Pilih pembeli</option>
                                @foreach ($pembeli as $item)
                                <option value="{{ $item->id }}" {{ old('id_pembeli',$transaksi->id_pembeli ?? ''  ) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_pembeli')
                            <span class="text-red-500 text-sm mt-1 animate-fade-in">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn col-span-1 md:col-span-2"
                            style="animation-delay: 400ms">
                            <label class="block text-sm md:text-base font-semibold text-gray-700">Keterangan</label>
                            <div class="mt-1">
                                <textarea name="keterangan" rows="2"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 text-sm md:text-base border-gray-300 rounded-lg">{{ old('keterangan',$transaksi->keterangan?? '') }}</textarea>
                            </div>
                            @error('keterangan')
                            <span class="text-red-500 text-sm mt-1 animate-fade-in">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4 mt-6 pt-4 border-t animate-fadeIn"
                        style="animation-delay: 500ms">
                        <a href="{{ route('crud_transaksi.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm md:text-base border border-gray-300 shadow-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="button"
                            onclick="confirmTransaksi(this)"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm md:text-base border border-transparent font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Simpan
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
function confirmTransaksi(button) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "akan menambahkan data transaksi",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, tambah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('transaksi-form').submit();
        }
    });
}
</script>
@endsection
