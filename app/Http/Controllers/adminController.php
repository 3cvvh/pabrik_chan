<?php

namespace App\Http\Controllers;

use App\Models\pabrik;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Detail_transaksi;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard',[
            'judul' => 'Dashboard|admin',
        ]);
    }
    public function tanggal(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            'tanggal_pengiriman' => 'nullable',
            'tanggal_pembayaran' => 'nullable',
        ]);
        Transaksi::where('id',$transaksi->id)->update($data);
        return redirect()->route('crud_transaksi.index')->with('success', 'Tanggal berhasil diperbarui');

    }
    public function produk(Request $request){
        $request->validate([
            'id_produk' => 'required'
        ]);
        $total_harga = 0;
        foreach($request->id_produk as $produk_id) {
        $jumlah = $request->jumlah[$produk_id] ?? 0;
        if ($jumlah <= 0) {
            return redirect(route('crud_transaksi.show',$request->id_tran))->with('gagal','harap jumlah diisi');
            die;
        }

        $produk = Produk::find($produk_id);
        $harga_total_produk = $produk->harga * $jumlah;
        $total_harga += $harga_total_produk;

        DB::table('detail_transaksis')->insert([
            'id_transaksi' => $request->id_tran,
            'id_produk' => $produk_id,
            'jumlah' => $jumlah,
            'total_harga' => $harga_total_produk,
        ]);
    }
    return redirect(route('crud_transaksi.index'))->with('success','berhasil di ganti');
    }
}
