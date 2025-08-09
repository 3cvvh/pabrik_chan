@extends('layout.main')
@section('content')
<form action="/dashboard/super_admin/crud_users" method="post">
@csrf
<label for="name">name:</label>
<input type="text" name="name" id="name"><br>
@error('name')
<span class="text-red-500 text-sm">{{ $message }}</span><br>
@enderror
<label for="email">email:</label>
<input type="email" name="email" id="email"><br>
@error('email')
<span class="text-red-500 text-sm">{{ $message }}</span><br>
@enderror
<label for="password">password:</label>
<input type="password" name="password" id="password"><br>
@error('password')
<span class="text-red-500 text-sm">{{ $message }}</span><br>
@enderror
<label for="alamat">alamat:</label>
<input type="alamat" name="alamat" id="alamat"><br>
@error('alamat')
<span class="text-red-500 text-sm">{{ $message }}</span><br>
@enderror
<label for="role">role:</label>
<select name="role_id" id="role">
    <option value="">pilih role</option>
    @foreach ($roles as $role)
        <option value="{{ $role->id }}">{{ $role->name }}</option>
    @endforeach
</select><br>
@error('role_id')
<span class="text-red-500 text-sm">{{ $message }}</span><br>
@enderror
<label for="pabrik">pabrik:</label>
<select name="pabrik_id" id="pabrik">
    <option value="">pilih pabrik</option>
    @foreach ($pabrik as $p)
        <option value="{{ $p->id }}">{{ $p->name }}</option>
    @endforeach
</select><br>
@error('pabrik_id')
<span class="text-red-500 text-sm">{{ $message }}</span><br>
@enderror
<button type="submit">Simpan</button>
<a href="/dashboard/super_admin/crud_users" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors duration-200">Kembali</a>
</form>
@endsection
