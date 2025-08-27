@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="bg-blue-100 min-h-screen pt-[64px] px-4 py-8 flex items-center justify-center">
    <div class="max-w-xl w-full bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">
            {{ isset($user) ? 'Edit Pengguna' : 'Tambah User Baru' }}
        </h2>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ isset($user) ? route('crud_user.update', $user->id) : route('crud_user.store') }}"
            method="POST"
            class="space-y-5"
        >
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="mt-1 block w-full px-4 py-2 border rounded-md" required />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="mt-1 block w-full px-4 py-2 border rounded-md" required />
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $user->alamat ?? '') }}" class="mt-1 block w-full px-4 py-2 border rounded-md" required />
            </div>

            <div>
                <label for="pabrik_id" class="block text-sm font-medium text-gray-700 mb-1">Pabrik</label>
                <input type="hidden" name="pabrik_id" id="pabrik_id" value="{{ old('pabrik_id', $user->pabrik_id ?? Auth::user()->pabrik_id) }}" />
                <div class="mt-1 block w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-700">
                    {{ isset($user) ? ($pabriks->where('id', $user->pabrik_id)->first()->name ?? '-') : ($pabriks->where('id', Auth::user()->pabrik_id)->first()->name ?? '-') }}
                </div>
            </div>

            {{-- Input Password untuk Tambah User --}}
            @if(!isset($user))
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full px-4 py-2 border rounded-md" required />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-4 py-2 border rounded-md" required />
            </div>
            @else
            {{-- Input Password Opsional untuk Edit User --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (opsional)</label>
                <input type="password" name="password" id="password" placeholder="Isi untuk mengubah password" class="mt-1 block w-full px-4 py-2 border rounded-md" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password (jika diubah)</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-4 py-2 border rounded-md" />
            </div>
            @endif

            <div>
                <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role_id" id="role_id" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="gudang-extra-input" style="display: none;">
                <select name="gudang_id" id="">
                    <option value="">pilih gudang</option>
                @foreach ( $gudang as $item )
                @if($item->id == old('gudang_id',$user->gudang_id?? ''))
                <option value="{{ $item->id }}" selected>{{ $item->nama }}</option>
                @endif
                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                </select>
            @endforeach
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('crud_user.index') }}" class="px-5 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none transition-colors">Simpan</button>
            </div>
        </form>
        {{-- Script untuk toggle input gudang --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const roleSelect = document.getElementById('role_id');
                const gudangInput = document.getElementById('gudang-extra-input');
                const kodeGudangInput = document.getElementById('kode_gudang');
                // Ambil id role "orang gudang" langsung dari koleksi (pastikan ada)
                const orangGudangRoleId = "{{ $roles->where('name', 'orang gudang')->first()->id ?? '' }}";
                // Debug: cek id dan value
                console.log('Orang Gudang Role ID:', orangGudangRoleId, 'Selected:', roleSelect.value);

                function toggleGudangInput() {
                    if (roleSelect.value === orangGudangRoleId && orangGudangRoleId !== '') {
                        gudangInput.style.display = '';
                        if (kodeGudangInput) kodeGudangInput.required = true;
                    } else {
                        gudangInput.style.display = 'none';
                        if (kodeGudangInput) kodeGudangInput.required = false;
                    }
                }

                roleSelect.addEventListener('change', toggleGudangInput);
                toggleGudangInput(); // initial check
            });
        </script>
    </div>
</div>
@endsection
