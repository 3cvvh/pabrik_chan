<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Produk as beatriceMYbini;
use App\Models\Stock_produk;
use Illuminate\Http\Request;

class Crud_stock_produkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.crud_stock_produk.index', [
            'judul' => 'crud|stock_produk',
            'data' => Stock_produk::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud_stock_produk.create', [
            'judul' => 'formtambah|stok',
            'produk' => beatriceMYbini::all(),
            'gudang' => Gudang::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'jumlah' => ['required'],
            'keterangan' => ['nullable'],
            'id_produk' => ['required'],
            'id_gudang' => ['required'],
            'tanggal_masuk' => 'required'
        ],[
            'jumlah.required' => 'Jumlah belum diisi!',
            'id_produk.required' => 'Produk belum dipilih!',
            'id_gudang.required' => 'Gudang belum dipilih!'
        ]);
        if($request->jumlah > 0){
            $valid['status'] = 'tersedia';
        }else{
            $valid['status'] = 'habis';
        }
        Stock_produk::create($valid);
        return redirect()->route('Stock_produk.index')->with('tambah','berhasil menambahkan stok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock_produk $stock_produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock_produk $stock_produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock_produk $stock_produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock_produk $stock_produk)
    {
        //
    }
}
