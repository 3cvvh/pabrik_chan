<?php

namespace App\Http\Controllers;

use App\Models\Detail_transaksi;
use DB;
use statustransaksi;
use App\Models\produk;
use App\Models\pembeli;
use App\Models\Pembeli as ModelsPembeli;
use App\Models\transaksi;
use App\Models\Transaksi as ModelsTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Models\Stock_produk;

class Crud_transaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $data = transaksi::with(['pembeli'])
    ->where('id','!=',Auth::user()->id)
    ->where('id_pabrik','=',Auth::user()->pabrik_id)
    ->latest();
     if($request->has('search') || $request->has('pembelis_key')){
        $data = transaksi::query()
            ->where('id', '!=', Auth::user()->id)
            ->when($request->search, function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('judul', 'like', '%'.$request->search.'%')
                      ->orWhere('status', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->pembelis_key, function($query) use ($request) {
                $query->where('id_pembeli', $request->pembelis_key);
            })
            ->with(['pembeli'])
            ->latest();
    }
        return view('admin.crud_transaksi.index',[
            'judul' => 'transaksi|page',
            'data' => $data->get(),
            'pembeli' => ModelsPembeli::where('id_pabrik',Auth::getUser()->pabrik_id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud_transaksi.create', [
            'judul' => 'transaksi|create',
            'pembeli' => pembeli::where('id_pabrik',Auth::user()->pabrik_id)->get(),
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
        'keterangan' => 'nullable',
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
        'status_pengiriman' => 'belum_dikirim',
        'status_pembayaran' => 'belum_bayar',
        'keterangan' => $request->keterangan,
    ]);

    // buat detail transaksi untuk setiap produk yang dipilih
    $total_harga = 0;
    foreach($request->id_produk as $produk_id) {
        $jumlah = $request->jumlah[$produk_id] ?? 0;
        if ($jumlah <= 0) {
            transaksi::destroy($transaksi->id);
            return redirect(route('crud_transaksi.create'))->with('warning','harap jumlah diisi');
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
            'harga_satuan' => $produk->harga
        ]);
    }

    $transaksi->update([
        'total_harga' => $total_harga
    ]);
    $stock = Stock_produk::where('id_produk',$produk_id)->where('id_pabrik',Auth::getUser()->pabrik_id)->where('jumlah','>','0')->get();
    foreach($stock as $stocks){
        if($stocks >= $jumlah){
            $stocks->jumlah -= $jumlah;
            $stocks->save();
            return redirect()->route('crud_transaksi.index')->with('success','berhasil menambahkan transaksi');
        }
        // }else{
        //     //   transaksi::destroy($transaksi->id);
        //     // Detail_transaksi::where('id_transaksi', $transaksi->id)->delete();
        //     // return redirect(route('crud_transaksi.create'))->with('warning','stok tidak mencukupi');
        //     return 'gagal';
        // }

    }

return redirect()->route('crud_transaksi.index')->with('gagal','stok tidak mencukupi');

    // redirect ke index dengan pesan sukses
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data =  transaksi::find($id);
        if(Auth::user()->pabrik_id !== $data->id_pabrik ){
            abort(404);
        }
        return view('admin.crud_transaksi.show',[
            'judul' => transaksi::find($id)->judul,
            'data_detail' => Detail_transaksi::with(['transaksi','produk'])->where('id_transaksi','=',$id)->get(),
            'data_transaksi' => $data,
            'dataproduk' => produk::where('id_pabrik',Auth::getUser()->pabrik_id)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $transaksi = transaksi::findOrFail($id);
        if(Auth::user()->pabrik_id !== $transaksi->id_pabrik ){
            abort(404);
        }
        return view('admin.crud_transaksi.create',[
            'judul' => 'edit transaksi',
            'transaksi' => $transaksi,
            'pembeli' => pembeli::where('id_pabrik',Auth::getUser()->pabrik_id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $transaksi = transaksi::find($id);
          $request->validate([
        'judul' => 'required',
        'id_pembeli' => 'required',
        'keterangan' => 'nullable',
    ],[
        'id_produk.required' => 'produk tidak dipilih',
        'id_pembeli.required' => 'pembeli tidak dipilih',
        'judul.required' => 'tolong nama transaksi diisi',
        'jumlah.required' => 'jumlah produk harap di isi',
        'jumlah.*.required' => 'jumlah produk harap di isi',
        'jumlah.*.numeric' => 'jumlah produk harus berupa angka',
        'jumlah.*.min' => 'jumlah produk minimal 1'
    ]);
    $transaksi->judul = $request->judul;
    $transaksi->id_pembeli = $request->id_pembeli;
    $transaksi->keterangan = $request->keterangan;
    $transaksi->save();
    return redirect()->route('crud_transaksi.index')->with('success','berhasil mengedit transaksi');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        transaksi::destroy($id);
        return redirect(route('crud_transaksi.index'))->with('success','berhasil menghapus data');
    }
}
