<?php

namespace App\Http\Controllers\orang_gudang;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Stock_produk;
use Illuminate\Support\Facades\Auth;

class Orang_gudangController extends Controller
{
    public function index(){
        return view('orang_gudang.dashboard',[
            'judul' => 'org_gudang|dashboard',
            'org_gudang' => count(User::where('gudang_id','=',Auth::user()->gudang_id)->get()),
            'total_stok' => count(Auth::user()->gudang->stock),
            'total_produk' => count(Auth::user()->pabrik->produk),
            'stok_produk' => Stock_produk::where('id_gudang','=',Auth::user()->gudang_id)->get()
        ]);
    }
}
