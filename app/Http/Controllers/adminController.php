<?php

namespace App\Http\Controllers;

use App\Models\pabrik;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard',[
            'judul' => 'Dashboard|admin',
        ]);
    }
    public function edit(pabrik $pabrik){
        return view('admin.form_pabrik_edit',[
            'judul' => 'edit',
            'pabrik' => $pabrik
        ]);
    }
}
