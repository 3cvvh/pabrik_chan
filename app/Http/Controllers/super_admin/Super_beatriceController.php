<?php

namespace App\Http\Controllers\super_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Super_beatriceController extends Controller
{
    public function index(){
        return view('super_admin.dashboard',[
            'judul' => 'hei'
        ]);
    }
}
