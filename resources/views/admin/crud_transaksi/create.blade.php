@extends('layout.main')
@section('content')
<div class="max-w-3xl mx-auto p-4">
    <div class="bg-white border rounded-lg shadow-lg transform transition-all duration-300 hover:scale-[1.01]">
        <div class="border-b p-4 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-semibold text-xl bg-clip-text text-transparent bg-gradient-to-r from-gray-700 to-gray-900">
               {{ isset($transaksi)? 'edit transaksi': 'tambah transaksi' }}
            </h2>
        </div>

        <form action="{{ isset($transaksi)? route('crud_transaksi.update',$transaksi->id) : route('crud_transaksi.store') }}" class="form" method="post" class="p-6">
            @csrf
            @if(isset($transaksi))
            @method('put')
            @endif
            <div class="space-y-4">
                <div class="group">
                    <label class="block mb-1 text-gray-700 group-hover:text-gray-900 transition-colors">Nama Transaksi
                    </label>
                    <input type="text" value="{{ old('judul',$transaksi->judul) }}" name="judul"
                        class="w-full h-10 px-3 border rounded-md transition-all duration-200
                        focus:ring-2 focus:ring-blue-100 focus:border-blue-400 hover:border-gray-400">
                    @error('judul')
                    <span class="text-red-500 text-sm mt-1 animate-fade-in">{{ $message }}</span>
                    @enderror
                </div>

                <div class="group">
                    <label class="block mb-1 text-gray-700 group-hover:text-gray-900 transition-colors">Pembeli</label>
                    <select name="id_pembeli"
                        class="w-full h-10 px-3 border rounded-md transition-all duration-200
                        focus:ring-2 focus:ring-blue-100 focus:border-blue-400 hover:border-gray-400">
                        <option value="">Pilih pembeli</option>
                        @foreach ($pembeli as $item)
                        <option value="{{ $item->id }}" {{ old('id_pembeli',$transaksi->id_pembeli  ) == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_pembeli')
                    <span class="text-red-500 text-sm mt-1 animate-fade-in">{{ $message }}</span>
                    @enderror
                </div>
                @if(!isset($transaksi))
                @if(isset($produk))
                <div class="group">
                    <label class="block mb-1 text-gray-700 group-hover:text-gray-900 transition-colors">Produk</label>
                    <div class="border rounded-md p-3 space-y-1 hover:border-gray-400 transition-colors">
                        @foreach ($produk as $item)
                        <div class="flex items-center p-2 rounded-md hover:bg-gray-50 transition-colors cursor-pointer gap-3">
                            <input type="checkbox" name="id_produk[]" value="{{ $item->id }}"
                                class="w-4 h-4 border-gray-300 rounded text-blue-500 transition-colors">
                            <span class="ml-2 select-none">{{ $item->nama }}</span>
                            <input type="number" min="0" name="jumlah[{{ $item->id }}]"
                                class="w-14 text-center border rounded ml-auto"
                                placeholder="0">
                        </div>
                        @endforeach
                    </div>
                    @error('id_produk')
                    <span class="text-red-500 text-sm mt-1 animate-fade-in">{{ $message }}</span>
                    @enderror
                        @error('jumlah.' . $item->id)
                        <span class="text-red-500 text-sm mt-1 animate-fade-in">{{ $message }}</span>
                        @enderror
                </div>
                @elseif(!isset($Produk))
                <h1>produk belum ditambahkan</h1>wdadaaaaaaaaaaaaaaaaaaa
                @endif
                  @endif

                <div class="grid grid-cols-2 gap-4">

                <div class="group">
                    <label class="block mb-1 text-gray-700 group-hover:text-gray-900 transition-colors">Keterangan
                    </label>
                    <textarea name="keterangan" rows="2"
                        class="w-full px-3 py-2 border rounded-md transition-all duration-200
                        focus:ring-2 focus:ring-blue-100 focus:border-blue-400 hover:border-gray-400">{{ old('keterangan',$transaksi->keterangan) }}</textarea>
                    @error('keterangan')
                    <span class="text-red-500 text-sm mt-1 animate-fade-in">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                <a href="{{ route('crud_transaksi.index') }}"
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

/* Input focus animations */
input:focus, select:focus, textarea:focus {
    animation: input-pop 0.2s ease-out;
}

@keyframes input-pop {
    50% { transform: scale(1.02); }
}

/* Checkbox animation */
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
        text: "akan menambahkan data transaksi",
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
@if(session('jumlah'))
    Swal.fire({
        icon: 'error',
        title: 'gagal!',
        text: '{{ session('jumlah') }}',
        timer: 1500,
        showConfirmButton: false
    });
@endif
</script>
@endsection
