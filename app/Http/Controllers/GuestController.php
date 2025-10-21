<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(){
        return view('guest.index',[
            'judul' => 'welcome|page'
        ]);
    }
    public function form_pabrik(){
        return view('guest.form_pabrik',[
            'judul' => 'form pabrik|page'
        ]);
    }
}
