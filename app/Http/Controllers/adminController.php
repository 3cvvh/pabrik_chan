<?php

namespace App\Http\Controllers;

use App\Models\pabrik;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Stock_produk;
use Illuminate\Http\Request;
use App\Models\Detail_transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
          $stock = Stock_produk::where('id_produk', $produk_id)->where('id_pabrik',Auth::getUser()->pabrik_id)->first();
            if ($detail) {
                // Jika sudah ada, update jumlah dan total_harga
                $new_jumlah = $detail->jumlah + $jumlah;
                $new_total = $produk->harga * $new_jumlah;
                if($stock){
                if($new_jumlah < $stock->jumlah){
                    $stock->jumlah -= $jumlah;
                    $stock->save();
                }elseif($stock->jumlah = null or $stock->jumlah < $new_jumlah){
                    return redirect(route('crud_transaksi.show',$request->id_tran))->with('gagal','stok tidak mencukupi');
                }}else{
                    return redirect(route('crud_transaksi.show',$request->id_tran))->with('gagal','stok tidak ditemukan');
                }
                if($new_jumlah <= 0) {
                    return redirect(route('crud_transaksi.show',$request->id_tran))->with('gagal','jumlah tidak boleh kurang dari 1');
                }
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
                    'jumlah' => $jumlah ,
                    'total_harga' => $harga_total_produk,
                    'harga_satuan' => $produk->harga
                ]);
                if($jumlah < $stock->jumlah){
                    $stock->jumlah -= $jumlah;
                    $stock->save();
                }else{
                    return redirect(route('crud_transaksi.show',$request->id_tran))->with('gagal','stok tidak mencukupi');
                }
            }
        }
        $stock = Stock_produk::where('id_produk',$produk_id)->first();
        if($stock->jumlah >= $jumlah){
            $stock->jumlah -= $jumlah;
            $stock->save();
        }
        // Update total_harga di transaksi
        return redirect(route('crud_transaksi.show',$request->id_tran))->with('berhasil','berhasil di tambahkan');
    }
    public function hapus_produk(Request $request, $id){
        Detail_transaksi::destroy($id);
        return redirect(route('crud_transaksi.show',$request->id_tran))->with('berhasil','berhasil menghapus produk');
    }
    public function generateReport(Transaksi $transaksi){
          return view('admin.crud_transaksi.laporan', [
            'judul' => 'Laporan Transaksi',
            'data_transaksi' => $transaksi,
            'data_detail' => Detail_transaksi::where('id_transaksi', $transaksi->id)->get(),
            'pabrik' => pabrik::find(Auth::getUser()->pabrik_id),
        ]);
    }
}
