@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="container mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-4">Tambah Gudang</h2>
    <form action="/dashboard/admin/crud_gudang" method="POST" class="bg-white p-6 rounded shadow-md max-w-lg">
        @csrf
        <div class="mb-4">
            <label for="id_pabrik" class="block font-semibold mb-1">Pilih Pabrik</label>
            <select name="id_pabrik" id="id_pabrik" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">-- Pilih Pabrik --</option>
                @foreach($pabrik as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="nama" class="block font-semibold mb-1">Nama Gudang</label>
            <input type="text" name="nama" id="nama" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="alamat" class="block font-semibold mb-1">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="no_telepon" class="block font-semibold mb-1">No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="keterangan" class="block font-semibold mb-1">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
        </div>
        <div class="mb-4">
            <label for="status" class="block font-semibold mb-1">Status</label>
            <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Simpan</button>
        <a href="/dashboard/admin/crud_gudang" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
