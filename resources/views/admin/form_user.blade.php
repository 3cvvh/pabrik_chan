@extends('layout.main')
@section('content')

<div class="min-h-screen bg-gray-100 py-8 px-2 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto animate-fadeIn">
        <!-- Card Header with animation -->
        <div class="mb-6 transform transition-all duration-500 animate-slideDown">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-blue-700 text-center">{{ isset($user) ? 'Edit Pengguna' : 'Tambah User Baru' }}</h2>
            <p class="mt-1 text-sm md:text-base text-gray-600 text-center">Silahkan isi data user dengan lengkap</p>
        </div>
        <!-- Main Card with hover effect and animation -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-500 hover:shadow-3xl animate-slideUp">
            <div class="p-4 sm:p-8">
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
                <form action="{{ isset($user) ? route('crud_user.update', $user->id) : route('crud_user.store') }}" method="POST" class="space-y-8">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 100ms">
                            <label for="name" class="block text-sm md:text-base font-semibold text-gray-700">Nama</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" required />
                            </div>
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 200ms">
                            <label for="email" class="block text-sm md:text-base font-semibold text-gray-700">Email</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" required />
                            </div>
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 200ms">
                            <label for="phone" class="block text-sm md:text-base font-semibold text-gray-700">no telepon</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="number" id="number" value="{{ old('phone', $user->phone ?? '') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" required />
                            </div>
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 300ms">
                            <label for="alamat" class="block text-sm md:text-base font-semibold text-gray-700">Alamat</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $user->alamat ?? '') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" required />
                            </div>
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 400ms">
                            <label for="pabrik_id" class="block text-sm md:text-base font-semibold text-gray-700">Pabrik</label>
                            <input type="hidden" name="pabrik_id" id="pabrik_id" value="{{ old('pabrik_id', $user->pabrik_id ?? Auth::user()->pabrik_id) }}" />
                            <div class="mt-1 block w-full py-3 px-4 border rounded-lg bg-gray-100 text-gray-700">
                                {{ isset($user) ? ($pabriks->where('id', $user->pabrik_id)->first()->name ?? '-') : ($pabriks->where('id', Auth::user()->pabrik_id)->first()->name ?? '-') }}
                            </div>
                        </div>
                        @if(!isset($user))
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 500ms">
                            <label for="password" class="block text-sm md:text-base font-semibold text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" name="password" id="password" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" required />
                            </div>
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 600ms">
                            <label for="password_confirmation" class="block text-sm md:text-base font-semibold text-gray-700">Konfirmasi Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" required />
                            </div>
                        </div>
                        @else
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 500ms">
                            <label for="password" class="block text-sm md:text-base font-semibold text-gray-700">Password (opsional)</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" name="password" id="password" placeholder="Isi untuk mengubah password" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" />
                            </div>
                        </div>
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 600ms">
                            <label for="password_confirmation" class="block text-sm md:text-base font-semibold text-gray-700">Konfirmasi Password (jika diubah)</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 px-4 text-sm md:text-base border-gray-300 rounded-lg" />
                            </div>
                        </div>
                        @endif
                        <div class="transform transition-all duration-300 animate-fadeIn col-span-1 md:col-span-2" style="animation-delay: 700ms">
                            <label for="role_id" class="block text-sm md:text-base font-semibold text-gray-700">Role</label>
                            <select name="role_id" id="role_id" class="mt-1 block w-full py-3 px-4 text-sm md:text-base border rounded-lg" required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="gudang-extra-input" class="col-span-1 md:col-span-2" style="display: none;">
                            <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1">Gudang</label>
                            <select name="gudang_id" id="" class="block w-full py-3 px-4 text-sm md:text-base border rounded-lg">
                                <option value="">pilih gudang</option>
                                @foreach ( $gudang as $item )
                                <option value="{{ $item->id }}" {{ old('gudang_id',$user->gudang->id ?? '') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4 pt-6 border-t animate-fadeIn" style="animation-delay: 800ms">
                        <a href="{{ route('crud_user.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm md:text-base border border-gray-300 shadow-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm md:text-base border border-transparent font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Simpan
                        </button>
                    </div>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const roleSelect = document.getElementById('role_id');
                        const gudangInput = document.getElementById('gudang-extra-input');
                        const kodeGudangInput = document.getElementById('kode_gudang');
                        const orangGudangRoleId = "{{ $roles->where('name', 'orang gudang')->first()->id ?? '' }}";
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
                        toggleGudangInput();
                    });
                </script>
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
@endsection
