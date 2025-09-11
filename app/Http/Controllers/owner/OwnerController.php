<?php

namespace App\Http\Controllers\owner;

use App\Models\User;
use App\Models\Gudang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Detail_transaksi;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{

    public function index(){
         $data = Transaksi::with(['pabrik','pembeli'])->where('id_pabrik',Auth::user()->pabrik_id);
         if(request()->filled('search')){
            $key =  trim(request()->search);
            $data->where('judul','LIKE','%'.$key.'%');
         }
        return view('owner.dashboard',[
            'judul' => 'owner|dashboard',
            'transaksi' => $data->get()
        ]);
    }
    public function generateLaporan() {
        return view('owner.generate_laporan', [
            'judul' => 'owner|generate laporan'
        ]);
    }
    public function dashboard(){
       $pabrikId = Auth::user()->pabrik_id;

        // pendapatan bersih per produk (hanya transaksi yang selesai)
$productNets = DB::table('detail_transaksis')
    ->join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
    ->join('produks', 'detail_transaksis.id_produk', '=', 'produks.id')
    ->where('transaksis.id_pabrik', $pabrikId)
    ->where('transaksis.status', 'completed')
    ->groupBy('produks.id', 'produks.nama')
    ->select('produks.id', 'produks.nama', DB::raw('COALESCE(SUM((detail_transaksis.harga_satuan - produks.harga_modal) * detail_transaksis.jumlah),0) as net'))
    ->get();

        $totalNet = $productNets->sum('net');

        return view('owner.dawgboard', [
            'judul' => 'owner|dawgboarrrr',
            'gudang' => count(Gudang::where('id_pabrik', $pabrikId)->get()),
            'admin' => count(User::where('pabrik_id', $pabrikId)->where('role_id','=',1)->get()),
            'orangGudang' => count(User::where('pabrik_id', $pabrikId)->where('role_id','=',2)->get()),
            'productNets' => $productNets,
            'totalNet' => $totalNet,
        ]);
}
public function laporanbos(){
    return view('owner.laporanbos',[
        'judul' => 'owner|laporanbos',
        'data' => Transaksi::where('id_pabrik',Auth::user()->pabrik_id)->get(),
    ]);
}
}

