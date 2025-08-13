<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Super_beatriceController extends Controller
{
    public function index(){
        return view('super_admin.dashboard',[
            'judul' => 'hei'
        ]);
    }
}
