@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="bg-blue-100 min-h-screen pt-[64px] px-6 py-8 rounded-2x1">
    <div class="max-w-lg mx-auto bg-white p-8 rounded-xl">
        <h2 class="text-xl font-semibold mb-6 text-center text-blue-600">Tambah User Baru</h2>
        <form action="{{ route('crud_user.index') }}" method="POST" class="space-y-4">
            @csrf
            @foreach ([
                'name' => 'Nama',
                'email' => 'Email',
                'alamat' => 'Alamat',
                'pabrik_id' => 'Pabrik',
                'role_id' => 'Role'
            ] as $field => $placeholder)
                <div class="flex flex-col">
                    <label for="{{ $field }}" class="text-sm text-gray-700 mb-1">{{ $placeholder }}</label>
                    <input
                        type="{{ $field === 'email' ? 'email' : 'text' }}"
                        name="{{ $field }}"
                        id="{{ $field }}"
                        placeholder="{{ $placeholder }}"
                        class="px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-400"></input>
                </div>
            @endforeach

            <button type="submit" class="w-40 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Simpan
            </button>
        </form>
    </div>
</div>

@endsection