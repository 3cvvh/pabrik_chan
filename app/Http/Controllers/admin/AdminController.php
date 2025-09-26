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
        $request->validate([
            'id_produk' => 'required'
        ]);
        $total_harga = 0;
        foreach($request->id_produk as $produk_id) {
            $jumlah = isset($request->jumlah[$produk_id]) ? (int)$request->jumlah[$produk_id] : 0;
            if ($jumlah <= 0) {
                return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','harap jumlah diisi');
            }
            $produk = Produk::find($produk_id);
            if(!$produk){
                return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','produk tidak ditemukan');
            }
            $harga_total_produk = $produk->harga_jual * $jumlah;
            $total_harga += $harga_total_produk;

            // Cek apakah produk sudah ada di detail_transaksi
            $detail = DB::table('detail_transaksis')
                ->where('id_transaksi', $id_transaksi)
                ->where('id_produk', $produk_id)
                ->first();

            $stock = Stock_produk::where('id_produk', $produk_id)
                ->where('id_pabrik', Auth::user()->pabrik_id)
                ->where('jumlah', '>', 0)
                ->first();

            // Pastikan stok valid
            if (!$stock || is_null($stock->jumlah)) {
                return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','stok tidak ditemukan');
            }

            if ($detail) {
                // Jika sudah ada, update jumlah dan total_harga
                $new_jumlah = $detail->jumlah + $jumlah;
                // Pastikan stok cukup untuk jumlah tambahan
                if ($stock->jumlah < $jumlah) {
                    return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','stok tidak mencukupi');
                }
                if($new_jumlah <= 0) {
                    return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','jumlah tidak boleh kurang dari 1');
                }
                DB::table('detail_transaksis')
                    ->where('id_transaksi', $id_transaksi)
                    ->where('id_produk', $produk_id)
                    ->update([
                        'jumlah' => $new_jumlah,
                        'total_harga' => $produk->harga_jual * $new_jumlah,
                    ]);
                $stock->jumlah -= $jumlah;
                $stock->save();
            } else {
                if ($stock->jumlah < $jumlah) {
                    return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','stok tidak mencukupi');
                }

                DB::table('detail_transaksis')->insert([
                    'id_transaksi' => $id_transaksi,
                    'id_produk' => $produk_id,
                    'jumlah' => $jumlah ,
                    'harga_modal' => $produk->harga_modal,
                    'total_harga' => $harga_total_produk,
                    'harga_satuan' => $produk->harga_jual
                ]);
                $stock->jumlah -= $jumlah;
                $stock->save();
            }
        }
        // Update total_harga di transaksi (jika perlu)
        return redirect(route('crud_transaksi.show',$id_transaksi))->with('berhasil','berhasil di tambahkan');
    }
    public function hapus_produk(Request $request, $id){
        $detail = Detail_transaksi::find($id);
        $stock = Stock_produk::where('id_produk','=',$detail->id_produk)->get();
        foreach($stock as $item){
            if($item){
                $item->jumlah += $detail->jumlah;
                $item->save();
            }
        }
        Detail_transaksi::destroy($id);
        return redirect(route('crud_transaksi.show',$detail->id_transaksi))->with('berhasil','berhasil menghapus produk');
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
