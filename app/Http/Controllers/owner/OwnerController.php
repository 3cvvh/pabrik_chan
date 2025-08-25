<?php

namespace App\Http\Controllers\owner;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{

    public function index(){
         $data = Transaksi::with(['pabrik','pembeli'])->where('id_pabrik',Auth::user()->pabrik_id);
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
}
