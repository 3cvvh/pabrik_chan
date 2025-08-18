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
        if($request->tanggal_pengiriman and $request->tanggal_pembayaran){
            $transaksi->status = 'completed';
            $transaksi->save();
        }
        return redirect()->route('crud_transaksi.show',$transaksi->id)->with('berhasil', 'Tanggal berhasil diperbarui');

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
            }
            $produk = Produk::find($produk_id);
            $harga_total_produk = $produk->harga * $jumlah;
            $total_harga += $harga_total_produk;

            // Cek apakah produk sudah ada di detail_transaksi
            $detail = DB::table('detail_transaksis')
                ->where('id_transaksi', $request->id_tran)
                ->where('id_produk', $produk_id)
                ->first();

            if ($detail) {
                // Jika sudah ada, update jumlah dan total_harga
                $new_jumlah = $detail->jumlah + $jumlah;
                $new_total = $produk->harga * $new_jumlah;
                DB::table('detail_transaksis')
                    ->where('id_transaksi', $request->id_tran)
                    ->where('id_produk', $produk_id)
                    ->update([
                        'jumlah' => $new_jumlah,
                        'total_harga' => $new_total,
                    ]);
            } else {
                // Jika belum ada, insert baru
                DB::table('detail_transaksis')->insert([
                    'id_transaksi' => $request->id_tran,
                    'id_produk' => $produk_id,
                    'jumlah' => $jumlah,
                    'total_harga' => $harga_total_produk,
                    'harga_satuan' => $produk->harga
                ]);
            }
        }
        return redirect(route('crud_transaksi.show',$request->id_tran))->with('berhasil','berhasil di tambahkan');
    }
    public function hapus_produk(Request $request, $id){
        Detail_transaksi::destroy($id);
        return redirect(route('crud_transaksi.show',$request->id_tran))->with('berhasil','berhasil menghapus produk');
    }
}
