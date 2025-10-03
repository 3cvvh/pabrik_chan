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

            // ambil semua stock yang tersedia untuk produk ini di pabrik/gudang user
            $pabrikId = Auth::user()->pabrik_id;
            $needed = $jumlah;

            $stocks = Stock_produk::where('id_produk', $produk_id)
                ->where(function($q) use ($pabrikId) {
                    $q->where('id_pabrik', $pabrikId)
                      ->orWhere('id_gudang', $pabrikId);
                })
                ->where('jumlah', '>', 0)
                ->orderBy('id','asc')
                ->get();

            foreach ($stocks as $stock) {
                if ($needed <= 0) break;

                $take = min($needed, $stock->jumlah);
                if ($take <= 0) continue;

                // update atau buat detail transaksi yang spesifik ke id_stock ini
                $detail = Detail_transaksi::where('id_transaksi', $id_transaksi)
                    ->where('id_produk', $produk_id)
                    ->where('id_stock', $stock->id)
                    ->first();

                if ($detail) {
                    $detail->jumlah += $take;
                    $detail->total_harga = $detail->jumlah * $produk->harga_jual;
                    if (!$detail->harga_modal) $detail->harga_modal = $produk->harga_modal;
                    $detail->save();
                } else {
                    Detail_transaksi::create([
                        'id_transaksi' => $id_transaksi,
                        'id_produk'    => $produk_id,
                        'id_stock'     => $stock->id,
                        'harga_modal'  => $produk->harga_modal,
                        'harga_satuan' => $produk->harga_jual,
                        'jumlah'       => $take,
                        'total_harga'  => $produk->harga_jual * $take,
                    ]);
                }

                // kurangi stock pada gudang tersebut
                $stock->jumlah -= $take;
                $stock->save();

                $needed -= $take;
            }
            if($stock->gudang->status !== 'aktif'){
                DB::rollBack();
                return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','Gudang '.$stock->gudang->nama.' sedang non-aktif, tidak bisa menambah stok!');
            }
            if ($needed > 0) {
                DB::rollBack();
                return redirect(route('crud_transaksi.show',$id_transaksi))->with('gagal','stok tidak mencukupi');
            }
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
            $restored = false;

            // 1) Jika ada id_stock pada detail, gunakan itu (paling pasti)
            if ($detail->id_stock) {
                $stock = Stock_produk::find($detail->id_stock);
                if ($stock) {
                    $stock->jumlah += $detail->jumlah;
                    $stock->save();
                    $restored = true;
                }
            }

            // 2) Jika belum dikembalikan, coba beberapa strategi pencarian
            if (! $restored) {
                $pabrikId = Auth::user()->pabrik_id;

                // a) coba cocokkan berdasarkan id_produk + id_pabrik + harga (jika tersedia)
                $query = Stock_produk::where('id_produk', $detail->id_produk)
                    ->where(function($q) use ($pabrikId) {
                        // beberapa instalasi menggunakan id_pabrik, beberapa id_gudang
                        $q->where('id_pabrik', $pabrikId)
                          ->orWhere('id_gudang', $pabrikId);
                    });

                $queryByPrice = (clone $query);
                $hasPriceCondition = false;
                $queryByPrice = $queryByPrice->where(function($q) use ($detail, &$hasPriceCondition) {
                    if (!is_null($detail->harga_modal)) {
                        $q->where('harga_modal', $detail->harga_modal);
                        $hasPriceCondition = true;
                    }
                    if (!is_null($detail->harga_satuan)) {
                        // cocokkan dengan kemungkinan nama kolom di stock
                        $q->orWhere('harga_jual', $detail->harga_satuan)
                          ->orWhere('harga_satuan', $detail->harga_satuan);
                        $hasPriceCondition = true;
                    }
                });

                if ($hasPriceCondition) {
                    $stock = $queryByPrice->orderBy('id','asc')->first();
                    if ($stock) {
                        $stock->jumlah += $detail->jumlah;
                        $stock->save();
                        $restored = true;
                    }
                }

                // b) jika belum, coba cari stock dengan id_produk dan pabrik/gudang yang sama, pilih terbaru (most recently updated)
                if (! $restored) {
                    $stock = $query->orderBy('updated_at', 'desc')->first();
                    if ($stock) {
                        $stock->jumlah += $detail->jumlah;
                        $stock->save();
                        $restored = true;
                    }
                }

                // c) terakhir, jika tidak ada stock sama sekali di pabrik, buat record baru (fallback aman)
                if (! $restored) {
                    $newStockData = [
                        'id_produk' => $detail->id_produk,
                        // gunakan id_pabrik sebagai default; beberapa instalasi menyimpan di id_gudang juga
                        'id_pabrik' => $pabrikId,
                        'jumlah' => $detail->jumlah,
                    ];
                    if (!is_null($detail->harga_modal)) $newStockData['harga_modal'] = $detail->harga_modal;
                    if (!is_null($detail->harga_satuan)) {
                        // simpan juga kemungkinan kolom harga_satuan/harga_jual
                        $newStockData['harga_satuan'] = $detail->harga_satuan;
                        $newStockData['harga_jual'] = $detail->harga_satuan;
                    }

                    $created = Stock_produk::create($newStockData);
                    if ($created) $restored = true;
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
