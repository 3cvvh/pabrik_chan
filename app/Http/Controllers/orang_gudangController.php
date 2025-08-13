<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Orang_gudangController extends Controller
{
    public function index(){
        return view('orang_gudang.dashboard',[
            'judul' => 'org_gudang|dashboard'
        ]);
    }
}
