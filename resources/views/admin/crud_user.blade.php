@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
<div class="bg-blue-100 min-h-screen px-8 pt-[64px]"> 
    <form action="{{ route('crud_user.index') }}" method="GET" class="flex items-center mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari User..." class="w-1/2 px-4 py-2 rounded-l bg-white focus:outline-none" /> {{-- search bar putih --}}
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r hover:bg-blue-700">Cari</button>
    </form>
    <div class="flex justify-end mb-4">
        <a href="{{ route('crud_user.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Tambah User
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow"> {{-- tambahkan bg-white agar tabel putih --}}
        <table class="min-w-full text-sm text-center">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Pabrik</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($data_user as $index => $user)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->alamat }}</td>
                    <td>{{ $user->pabrik->name ?? '-' }}</td>
                    <td>{{ $user->role->name ?? '-' }}</td>
                    <td class="space-x-2">
                         <a href="/dashboard/admin/crud_edit" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-3 rounded mr-2 transition">Edit</a>
                        <form action="" method="POST" class="inline" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded transition" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-4 text-gray-500">Belum ada data user</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
