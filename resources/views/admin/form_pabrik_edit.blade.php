@extends('layout.main')
@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-lg mx-auto">
                <div class="mb-6">
            <a href="/dashboard/admin/crud_pabrik" class="inline-flex items-center text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

                <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Pabrik</h2>

            <form action="/dashboard/admin/crud_pabrik/{{ $pabrik->id }}" method="post" class="space-y-6">
                @csrf
                @method('put')
                <input type="hidden" name="id" value="{{ $pabrik->id }}">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pabrik</label>
                    <input type="text" name="name" id="name"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Masukkan nama pabrik"
                        value="{{ $pabrik->name }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <input type="text" name="alamat" id="alamat"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Masukkan alamat pabrik"
                        value="{{ $pabrik->alamat }}">
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
                    <input type="number" name="no_telepon" id="no_telepon"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Masukkan nomor telepon"
                        value="{{ $pabrik->no_telepon }}">
                    @error('no_telepon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Update Data
                </button>
            </form>
        </div>
    </div>
</div>
@endsection