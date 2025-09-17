<?php

namespace App\Http\Controllers\orang_gudang;

use App\Models\Gudang;
use App\Models\Pabrik;
use App\Models\Produk;
use App\Models\Stock_produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk as beatriceMYbini;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Crud_stock_produk2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stock = Stock_produk::with(['produk','gudang'])->where('id_pabrik', Auth::user()->pabrik_id);

        // Filter teks pencarian: cari di nama produk, nama gudang, jumlah atau status
        if ($request->filled('search')) {
            $q = trim($request->search);
            $stock->where(function($query) use ($q) {
                $query->whereHas('produk', function($q2) use ($q) {
                    $q2->where('nama', 'like', '%' . $q . '%');
                })->orWhereHas('gudang', function($q3) use ($q) {
                    $q3->where('nama', 'like', '%' . $q . '%');
                })->orWhere('jumlah', 'like', '%' . $q . '%')
                  ->orWhere('status', 'like', '%' . $q . '%');
            });
        }

        // Filter by produk
        if ($request->filled('produk')) {
            $stock->where('id_produk', $request->produk);
        }

        // Filter by gudang
        if ($request->filled('gudang')) {
            $stock->where('id_gudang', $request->gudang);
        }

        // Data untuk select filter di view
        $produks = Produk::where('id_pabrik', Auth::user()->pabrik_id)->get();
        $gudangs = Gudang::where('id_pabrik', Auth::user()->pabrik_id)->get();

        return view('orang_gudang.crud_stock.index', [
            'judul' => 'crud|stock_produk',
            'data' => $stock->latest()->paginate(3),
            'produks' => $produks,
            'gudang' => $gudangs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orang_gudang.crud_stock.create', [
            'judul' => 'formtambah|stok',
            'produk' => beatriceMYbini::where('id_pabrik', Auth::getUser()->pabrik_id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $stock_ada = Stock_produk::where('id_produk',$request->id_produk)->get();
        $valid = $request->validate([
            'jumlah' => ['required'],
            'keterangan' => ['nullable'],
            'id_produk' => ['required'],
            'tanggal_masuk' => ['required']
        ],[
            'jumlah.required' => 'Jumlah belum diisi!',
            'id_produk.required' => 'Produk belum dipilih!',
        ]);
        $valid['id_pabrik'] = Auth::user()->pabrik_id;
        $valid['id_gudang'] = Auth::user()->gudang_id;
        if($request->jumlah > 0){
            $valid['status'] = 'tersedia';
        }else{
            $valid['status'] = 'habis';
        }
        foreach($stock_ada as $stock){
            if($stock->id_gudang == $request->id_gudang){
                $gudang = Gudang::find($request->id_gudang)->nama;
                return redirect()->route('crud_stocks.index')->with('warning','stock di ' . $gudang . ' sudah ada' );
            }
        }
        Stock_produk::create($valid);
        return redirect()->route('crud_stocks.index')->with('berhasil','berhasil menambahkan stok');
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
        return view('orang_gudang.crud_stock.edit',[
            'judul' => 'edit|stok',
            'data' => Stock_produk::all(),
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
        ]);
        if($request->jumlah <= 0){
            $stock_produk->status = 'habis';
        }elseif($request->jumlah > 0){
            $stock_produk->status = 'tersedia';
        }
        $stock_produk->jumlah = $request->jumlah;
        $stock_produk->tanggal_masuk = $request->tanggal_masuk;
        $stock_produk->keterangan = $request->keterangan;
        $stock_produk->save();
        return redirect(route('crud_stocks.index'))->with('berhasil','berhasil mengedit stok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Stock_produk::findOrFail($id);
        $data->delete();
        return redirect()->route('crud_stocks.index')->with('berhasil','berhasil menghapus data');
    }
}
