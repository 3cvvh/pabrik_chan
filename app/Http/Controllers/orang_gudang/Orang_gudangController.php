<?php

namespace App\Http\Controllers\orang_gudang;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Stock_produk;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;

class Orang_gudangController extends Controller
{
    public function index(){
    return view('orang_gudang.dashboard',[
        'judul' => 'org_gudang|dashboard',
        'org_gudang' => User::where('gudang_id', Auth::user()->gudang_id)->count(),
        'total_stok' => Stock_produk::where('id_gudang', Auth::user()->gudang_id)->where('id_pabrik', Auth::user()->pabrik_id)->count(),
        'total_produk' => Produk::where('id_pabrik', Auth::user()->pabrik_id)->where('id_gudang', Auth::user()->gudang_id)->count(),
        'stok_produk' => Stock_produk::where('id_gudang', Auth::user()->gudang_id)->where('id_pabrik', Auth::user()->pabrik_id)->with('produk')->get()

    ]);
}

}
