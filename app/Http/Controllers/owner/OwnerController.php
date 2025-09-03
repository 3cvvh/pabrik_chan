<?php

namespace App\Http\Controllers\owner;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gudang;
use App\Models\User;
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
        return view('owner.dawgboard', [
            'judul' => 'owner|dawgboarrrr',
            'gudang' => count(Gudang::where('id_pabrik',Auth::user()->pabrik_id)->get()),
            'admin' => count(User::where('pabrik_id',Auth::user()->pabrik_id)->where('role_id','=',1)->get()),
            'orangGudang' => count(User::where('pabrik_id',Auth::getUser()->pabrik_id)->where('role_id','=',2)->get())
        ]);
    }
}

