<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Pabrik;
use App\Models\Produk as beatriceMYbini;
use App\Models\Produk;
use App\Models\Stock_produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Crud_stock_produkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.crud_stock_produk.index', [
            'judul' => 'crud|stock_produk',
            'data' => Stock_produk::where('id_pabrik',Auth::getUser()->pabrik_id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud_stock_produk.create', [
            'judul' => 'formtambah|stok',
            'produk' => beatriceMYbini::where('id_pabrik', Auth::getUser()->pabrik_id)->get(),
            'gudang' => Gudang::where('id_pabrik', Auth::getUser()->pabrik_id)->get(),
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
        $valid['id_pabrik'] = Auth::user()->pabrik_id;
        if($request->jumlah > 0){
            $valid['status'] = 'tersedia';
        }else{
            $valid['status'] = 'habis';
        }
        Stock_produk::create($valid);
        return redirect()->route('Stock_produk.index')->with('berhasil','berhasil menambahkan stok');
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
    public function edit($id)
    {
        $stock = Stock_produk::find($id);
        return view('admin.crud_stock_produk.edit',[
            'judul' => 'edit|stok',
            'data' => Stock_produk::all(),
            'gudang' => Gudang::where('id_pabrik', Auth::getUser()->pabrik_id)->get(),
            'stock' => $stock
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $stock_produk = Stock_produk::find($id);
        $request->validate([
            'jumlah' => ['required'],
            'tanggal_masuk' => ['required'],
            'keterangan' => 'nullable',
            'gudang' => 'integer',
        ]);
        if($request->jumlah == 0){
            $stock_produk->status = 'habis';
        }
        $stock_produk->jumlah = $request->jumlah;
        $stock_produk->id_gudang = $request->gudang;
        $stock_produk->tanggal_masuk = $request->tanggal_masuk;
        $stock_produk->keterangan = $request->keterangan;
        $stock_produk->save();
        return redirect()->route('Stock_produk.index')->with('berhasil','berhasil mengedit stok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Stock_produk::findOrFail($id);
        $data->delete();
        return redirect()->route('Stock_produk.index')->with('hapus','berhasil menghapus data');
    }
}
