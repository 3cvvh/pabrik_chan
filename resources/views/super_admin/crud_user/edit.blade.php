@extends('layout.main')
@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto animate-fadeIn">
        <!-- Card Header -->
        <div class="mb-6 transform transition-all duration-500 animate-slideDown">
            <h2 class="text-3xl font-extrabold text-gray-900">Edit User</h2>
            <p class="mt-1 text-sm text-gray-600">Ubah data user sesuai kebutuhan</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-500 hover:shadow-3xl animate-slideUp">
            <div class="p-8">
                <form id="edit-form" action="{{ route('crud_users.update',$data->id) }}" method="post" class="space-y-8">
                    @csrf
                    @method('put')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 100ms">
                            <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name',$data->name) }}"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 py-3 text-sm border-gray-300 rounded-lg">
                            </div>
                            @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 200ms">
                            <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email',$data->email) }}"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 py-3 text-sm border-gray-300 rounded-lg">
                            </div>
                            @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 300ms">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input type="password" name="password" id="password"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-10 py-3 text-sm border-gray-300 rounded-lg"
                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                                <button type="button"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center transition-opacity duration-200"
                                    onclick="togglePassword()">
                                    <svg id="eye-open" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eye-closed" class="hidden h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Input -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 400ms">
                            <label for="alamat" class="block text-sm font-semibold text-gray-700">Alamat</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <input type="text" name="alamat" id="alamat" value="{{ old('alamat',$data->alamat) }}"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 py-3 text-sm border-gray-300 rounded-lg">
                            </div>
                            @error('alamat')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role Select -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 500ms">
                            <label for="role" class="block text-sm font-semibold text-gray-700">Role</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <select name="role_id" id="role" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 pl-3 pr-10 text-sm border-gray-300 rounded-lg appearance-none">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $data->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('role_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pabrik Select -->
                        <div class="transform transition-all duration-300 animate-fadeIn" style="animation-delay: 600ms">
                            <label for="pabrik" class="block text-sm font-semibold text-gray-700">Pabrik</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <select name="pabrik_id" id="pabrik" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-3 pl-3 pr-10 text-sm border-gray-300 rounded-lg appearance-none">
                                    @foreach ($pabriks as $pabrik)
                                        <option value="{{ $pabrik->id }}" {{ old('pabrik_id', $data->pabrik_id) == $pabrik->id ? 'selected' : '' }}>
                                            {{ $pabrik->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('pabrik_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 pt-6 border-t animate-fadeIn" style="animation-delay: 700ms">
                        <a href="/dashboard/super_admin/crud_users"
                           class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white transform transition-all duration-300 hover:scale-105 hover:bg-gray-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali
                        </a>
                        <button type="button" onclick="confirmedit()"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 transform transition-all duration-300 hover:scale-105 hover:bg-indigo-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Data
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
function togglePassword() {
    const password = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');

    if (password.type === 'password') {
        password.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        password.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    }
}
function confirmedit() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan mengubah data user ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('edit-form').submit();
            }
        })
    }
</script>
@endsection
