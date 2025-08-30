<?php

namespace App\Http\Controllers\super_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pabrik;
use App\Models\User;

class Super_beatriceController extends Controller
{
    public function index(){
        return view('super_admin.dashboard',[
            'judul' => 'hei',
            'pabrik' =>count(Pabrik::all()),
            'admin' => count(User::where('role_id',1)->get()),
            'owner' => count(User::where('role_id',3)->get()),
            'orang_gudang' => count(User::where('role_id',2)->get()),
        ]);
    }
}
