<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ownerController extends Controller
{
    public function index(){
        return view('owner.dashboard',[
            'judul' => 'owner|dashboard'
        ]);
    }
}
