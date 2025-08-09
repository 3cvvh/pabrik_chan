@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="container mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-4">Data Pabrik</h2>
   @foreach (['tambah' => 'blue', 'edit' => 'yellow', 'hapus' => 'red', 'success' => 'green', 'error' => 'red'] as $message => $color)
    @if (session($message))
        <div class="mb-4 p-4 bg-{{ $color }}-100 border-l-4 border-{{ $color }}-500 text-{{ $color }}-700 rounded">
            <p>{{ session($message) }}</p>
        </div>
    @endif
@endforeach
    <a href="/dashboard/super_admin/crud_pabrik/create" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-4 transition">Tambah Pabrik</a>
    <div class="overflow-x-auto rounded shadow">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 border-b text-left">No</th>
                    <th class="py-3 px-4 border-b text-left">Nama Pabrik</th>
                    <th class="py-3 px-4 border-b text-left">Alamat</th>
                    <th class="py-3 px-4 border-b text-left">Logo</th>
                    <th class="py-3 px-4 border-b text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pabrik as $index => $pabrik)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $index+1 }}</td>
                    <td class="py-2 px-4 border-b">{{ $pabrik->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $pabrik->alamat }}</td>
                    <td class="py-2 px-4 border-b">
                        @if ($pabrik->gambar)
                            <img src="{{ asset('storage/' . $pabrik->gambar) }}" alt="Gambar Pabrik" class="w-16 h-16 object-cover rounded-md">
                        @else
                            <span class="text-gray-500">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="/dashboard/super_admin/crud_pabrik/{{ $pabrik->id }}/edit" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-3 rounded mr-2 transition">Edit</a>
                        <form action="/dashboard/super_admin/crud_pabrik/{{ $pabrik->id }}" method="POST" class="inline" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $pabrik->id }}">
                            <button  type ="submit" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded transition" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Data tidak ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
