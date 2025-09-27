<?php

namespace App\Http\Controllers\admin;

use App\Models\pabrik;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Stock_produk;
use Illuminate\Http\Request;
use App\Models\Detail_transaksi;
use Illuminate\Cache\RedisTagSet;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pembeli;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $pabrik_id = Auth::user()->pabrik_id;
        return view('admin.dashboard',[
            'judul' => 'Dashboard|admin',
            'user' => count(User::where('pabrik_id','=', Auth::user()->pabrik_id)->get()),
            'produk' => count(Auth::user()->pabrik->produk),
            'gudang' => count(Auth::user()->pabrik->gudang),
            'pembeli' => count(Pembeli::where('id_pabrik','=',$pabrik_id)->get()),
            'total_stock' => Stock_produk::where('id_gudang', $pabrik_id )->sum('jumlah'),
            'transaksi' => Transaksi::where('id_pabrik', $pabrik_id)->count()
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
    public function produk(Request $request, $id_transaksi){
    $request->validate(['id_produk' => 'required']);
    DB::beginTransaction();
    try {
        foreach($request->id_produk as $produk_id) {
            $jumlah = isset($request->jumlah[$produk_id]) ? (int)$request->jumlah[$produk_id] : 0;
            if ($jumlah <= 0) return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','harap jumlah diisi');

            $produk = Produk::find($produk_id);
            if(!$produk) return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','produk tidak ditemukan');

            // pilih stock yang memberikan (misal stock di pabrik/gudang user dengan jumlah cukup)
            $stock = Stock_produk::where('id_produk', $produk_id)
                ->where('id_pabrik', Auth::user()->pabrik_id)
                ->where('jumlah', '>=', $jumlah)
                ->first();

            if (!$stock) return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','stok tidak mencukupi');

            // cek apakah sudah ada detail untuk produk ini pada transaksi
            $detail = Detail_transaksi::where('id_transaksi', $id_transaksi)
                ->where('id_produk', $produk_id)
                ->first();

            if ($detail) {
            $detail->jumlah += $jumlah;
             $detail->total_harga = $detail->jumlah * $produk->harga_jual;
            if (!$detail->id_stock) $detail->id_stock = $stock->id;
            if (!$detail->harga_modal) $detail->harga_modal = $produk->harga_modal;
            $detail->save();
            } else {
            Detail_transaksi::create([
            'id_transaksi' => $id_transaksi,
            'id_produk'    => $produk_id,
            'id_stock'     => $stock->id,
            'harga_modal'  => $produk->harga_modal,
            'harga_satuan' => $produk->harga_jual,
            'jumlah'       => $jumlah,
            'total_harga'  => $produk->harga_jual * $jumlah,
]);
            }

            // kurangi stock
            $stock->jumlah -= $jumlah;
            $stock->save();
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','Terjadi kesalahan: '.$e->getMessage());
    }

    return redirect(route('crud_transaksi.show',$id_transaksi))->with('berhasil','berhasil di tambahkan');
}
    public function hapus_produk(Request $request, $id){
        $detail = Detail_transaksi::find($id);
    if (!$detail) return redirect()->back()->with('gagal','Detail transaksi tidak ditemukan');

    DB::beginTransaction();
    try {
        // jika ada id_stock pada detail, gunakan itu
        if ($detail->id_stock) {
            $stock = Stock_produk::find($detail->id_stock);
            if ($stock) {
                $stock->jumlah += $detail->jumlah;
                $stock->save();
            }
        } else {
            // fallback: cari stock berdasarkan id_produk dan id_pabrik/gudang
            $stocks = Stock_produk::where('id_produk', $detail->id_produk)
                ->where('id_pabrik', Auth::user()->pabrik_id)
                ->orderBy('id','asc')
                ->get();
            if ($stocks->isNotEmpty()) {
                // tambahkan ke stock pertama (atau logic lain sesuai kebutuhan)
                $s = $stocks->first();
                $s->jumlah += $detail->jumlah;
                $s->save();
            }
        }

        $transaksiId = $detail->id_transaksi;
        $detail->delete();

        DB::commit();
        return redirect(route('crud_transaksi.show',$transaksiId))->with('berhasil','berhasil menghapus produk');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('gagal','Gagal menghapus produk: '.$e->getMessage());
    }
    }
    public function generateReport(Transaksi $transaksi){
        if($transaksi->id_pabrik != Auth::user()->pabrik_id){
            return redirect()->route('admin.index')->with('gagal','Anda tidak memiliki akses ke laporan ini');
        }
          return view('admin.crud_transaksi.laporan', [
            'judul' => 'Laporan Transaksi',
            'data_transaksi' => $transaksi,
            'data_detail' => Detail_transaksi::where('id_transaksi', $transaksi->id)->get(),
            'pabrik' => pabrik::find(Auth::getUser()->pabrik_id),
        ]);
    }
}
