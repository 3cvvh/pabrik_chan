<?php

namespace App\Http\Controllers;

use App\Models\Pabrik;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\pabrik as pabrikss;
use Illuminate\Support\Facades\Auth;

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
    public function request(){
        $allpabrik = \App\Models\Pabrik::all();
        $judul = 'request pabrik|page';
        return view('guest.request', compact('allpabrik','judul'));
    }
    public function store_pabrik(Request $request,$id){
        $request->validate([
            'nama_pabrik' => ['required'],
            'alamat_pabrik' => 'required',
            'nomor_telepon' => 'required',
        ]);
        $new = new pabrikss;
        $new->name = $request->nama_pabrik;
        $new->alamat = $request->alamat_pabrik;
        $new->no_telepon = $request->nomor_telepon;
        $new->save();
        $update_user = User::find($id);
        $update_user->pabrik_id = $new->id;
        $update_user->save();
        Auth::login($update_user);
        $request->session()->regenerate();
        return redirect()->route('admin.index');
    }
}
