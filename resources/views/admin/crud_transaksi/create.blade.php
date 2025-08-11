@extends('layout.main')
@section('content')
<form action="{{ route('crud_transaksi.store') }}" method="post">
    @csrf
<label for="judul">nama transaksi:</label>
<input type="text" name="judul"><br>
<label for="pembeli">pembeli:</label>
<select name="id_pembeli" id="pembeli">
    @foreach ($pembeli as $item )
    @if($item->id == old('id_pembeli'))
    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
    @endif
    <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endforeach
</select><br>
<label for="produk">produk:</label>
@foreach ( $produk as $item )
<input type="checkbox" name="id_produk" value="{{ $item->id }}" id="{{ $item->id }}" @if(is_array(old('id_produk')) && in_array($item->id, old('id_produk'))) checked @endif>
<label for="{{ $item->id }}">{{ $item->nama }}</label>
@endforeach
<br>
<label for="jumlah">jumlah:</label>
<input type="number" name="jumlah" value="{{ old('jumlah') }}"><br>
<label for="harga">harga:</label>
<input type="number" name="total_harga" value="{{ old('total_harga') }}"><br>
<label for="keterangan">keterangan</label>
<input type="text" name="keterangan" value="{{ old('keterangan') }}" placeholder="keterangan"><br>
<button type="submit">Simpan</button>
</form>
@endsection
