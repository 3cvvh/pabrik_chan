@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="bg-blue-100 min-h-screen px-4 md:px-8 pt-[64px]">
    <div class="max-w-7xl mx-auto py-8">
        {{-- Notifikasi Flash --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-700">Daftar Pengguna</h1>
            <a href="{{ route('crud_user.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i> Tambah User
            </a>
        </div>

        {{-- Search Form --}}
        <form method="GET" action="{{ route('crud_user.index') }}" class="mb-6 flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari User..." class="flex-1 px-4 py-2 rounded-l-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-white">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r-lg hover:bg-white transition-colors">Cari</button>
        </form>

        <div class="overflow-x-auto bg-white rounded-1 shadow-md">
            <table class="min-w-full border border-gray-300">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 border border-gray-300 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 border border-gray-300 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 border border-gray-300 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 border border-gray-300 text-left text-xs font-medium uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 border border-gray-300 text-left text-xs font-medium uppercase tracking-wider">Pabrik</th>
                        <th class="px-6 py-3 border border-gray-300 text-left text-xs font-medium uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 border border-gray-300 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($data_user as $index => $user)
                    <tr>
                        <td class="px-6 py-4 border border-gray-300 whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 border border-gray-300 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 border border-gray-300 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 border border-gray-300 whitespace-nowrap">{{ $user->alamat ?? '-' }}</td>
                        <td class="px-6 py-4 border border-gray-300 whitespace-nowrap">{{ $user->pabrik->name ?? '-' }}</td>
                        <td class="px-6 py-4 border border-gray-300 whitespace-nowrap">{{ $user->role->name ?? '-' }}</td>
                        <td class="px-6 py-4 border border-gray-300 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('crud_user.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('crud_user.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 border border-gray-300 whitespace-nowrap text-center text-gray-500">Belum ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection