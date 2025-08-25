<?php

namespace App\Http\Controllers\orang_gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Orang_gudangController extends Controller
{
    public function index(){
        return view('orang_gudang.dashboard',[
            'judul' => 'org_gudang|dashboard'
        ]);
    }
}
