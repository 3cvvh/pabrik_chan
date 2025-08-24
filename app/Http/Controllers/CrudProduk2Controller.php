<?php

namespace App\Http\Controllers;

use App\Models\pabrik;
use App\Models\Pabrik as ModelsPabrik;
use App\Models\produk;
use App\Models\Produk as ModelsProduk;
use App\Models\Stock_produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CrudProduk2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.crud_produk.index',[
            'judul' => 'crud|produk',
            'data' =>  produk::where('id_pabrik','=',Auth::getUser()->pabrik_id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud_produk.form_tambah_produk',[
            'judul' => 'formtambah|produk',
            'pabrik' => pabrik::where('id',Auth::user()->pabrik_id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'nama' => 'required',
            'harga' => ['required'],
            'deskripsi' => 'nullable',
            'gambar' => ['image','nullable'],
            'id_pabrik' => 'integer'
        ]);
        if($request->file('gambar')){
            $valid['gambar'] = $request->file('gambar')->store('produk-img');
        }
        produk::create($valid);
        return redirect()->route('produk.index')->with('berhasil','berhasil menambahkan produk');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produk = produk::find($id);
                if($produk->id_pabrik != Auth::user()->pabrik_id OR $produk->id == null){
            abort(404);
        }
        if($produk->id == null){
            abort(404);
        }
        return view('admin.crud_produk.show', [
            'judul' => $produk->judul,
            'produk' => $produk,
            'stock' => Stock_produk::where('id_produk', '=',$produk->id)->get()

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produk = produk::find($id);
            return view('admin.crud_produk.edit', [
            'judul' => $produk->judul,
            'data' => $produk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produk = produk::find($id);
        $valid = $request->validate([
            'nama' => ['required'],
            'harga' => ['required'],
            'deskripsi' => 'nullable',
            'gambar' => ['nullable','image'],
        ]);
        if($request->file('gambar')){
            if($produk->gambar){
                Storage::delete($produk->gambar);
            }
            $valid['gambar'] = $request->file('gambar')->store('produk-img');
        }
        produk::where('id','=',$produk->id)->update($valid);
        return redirect()->route('produk.index')->with('edit','berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = produk::find($id);
        if($produk->gambar){
            Storage::delete($produk->gambar);
        }
        ModelsProduk::destroy($produk->id);
        return redirect()->route('produk.index')->with('hapus','berhasil menghapus data');
    }
}
