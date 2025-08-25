<?php

namespace App\Http\Controllers\owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnerController extends Controller
{
    public function index(){
        return view('owner.dashboard',[
            'judul' => 'owner|dashboard'
        ]);
    }
    public function generateLaporan() {
        return view('owner.generate_laporan', [
            'judul' => 'owner|generate laporan'
        ]);
    }
}
