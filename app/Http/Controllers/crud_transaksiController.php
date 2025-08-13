<?php

namespace App\Http\Controllers;

use App\Models\Detail_transaksi;
use DB;
use statustransaksi;
use App\Models\produk;
use App\Models\pembeli;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class Crud_transaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $t = transaksi::with(['pembeli','pabrik'])->where('id_pabrik','=',Auth::user()->pabrik_id);
        return view('admin.crud_transaksi.index',[
            'judul' => 'transaksi|page',
            'data' => $t->get(),
            'pembeli' => pembeli::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud_transaksi.create', [
            'judul' => 'transaksi|create',
            'pembeli' => pembeli::all(),
            'produk' => produk::where('id_pabrik', Auth::user()->pabrik_id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // Validasi request btw beatrice kawwaii
    $request->validate([
        'judul' => 'required',
        'id_pembeli' => 'required',
        'id_produk' => 'required|array',
        'jumlah' => 'required|array',
        'keterangan' => 'nullable'
    ],[
        'id_produk.required' => 'produk tidak dipilih',
        'id_pembeli.required' => 'pembeli tidak dipilih',
        'judul.required' => 'tolong nama transaksi diisi',
        'jumlah.required' => 'jumlah produk harap di isi',
        'jumlah.*.required' => 'jumlah produk harap di isi',
        'jumlah.*.numeric' => 'jumlah produk harus berupa angka',
        'jumlah.*.min' => 'jumlah produk minimal 1'
    ]);

    // create transaksi
    $transaksi = transaksi::create([
        'judul' => $request->judul,
        'id_pembeli' => $request->id_pembeli,
        'id_pabrik' => Auth::user()->pabrik_id,
        'keterangan' => $request->keterangan,
        'status_pengiriman' => 'belum_dikirim',
        'status_pembayaran' => 'belum_bayar'
    ]);

    // buat detail transaksi untuk setiap produk yang dipilih
    $total_harga = 0;
    foreach($request->id_produk as $produk_id) {
        $jumlah = $request->jumlah[$produk_id] ?? 0;
        if ($jumlah <= 0) {
            transaksi::destroy($transaksi->id);
            return redirect(route('crud_transaksi.create'))->with('jumlah','harap jumlah diisi');
            die;
        }

        $produk = Produk::find($produk_id);
        $harga_total_produk = $produk->harga * $jumlah;
        $total_harga += $harga_total_produk;

        FacadesDB::table('detail_transaksis')->insert([
            'id_transaksi' => $transaksi->id,
            'id_produk' => $produk_id,
            'jumlah' => $jumlah,
            'total_harga' => $harga_total_produk,
        ]);
    }

    $transaksi->update([
        'total_harga' => $total_harga
    ]);

    return redirect()->route('crud_transaksi.index')
        ->with('success', 'Transaksi berhasil dibuat');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('admin.crud_transaksi.show',[
            'judul' => transaksi::find($id)->judul,
            'data_detail' => Detail_transaksi::with(['transaksi','produk'])->where('id_transaksi','=',$id)->get(),
            'data_transaksi' => transaksi::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }
}
