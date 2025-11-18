<?php

namespace App\Http\Controllers;

use App\Models\Pabrik;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\pabrik as pabrikss;
use App\Models\Payment;
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
            'nomor_telepon' => ['required','min:10'],
            'email' => ['required','email','unique:pabriks,email'],
            'gambar_pabrik' => 'image'
        ]);

       $new = new pabrikss;
       if($request->file('gambar_pabrik')){
        $new->gambar = $request->file('gambar_pabrik')->store('pabriks-img');
       }
        $new->name = $request->nama_pabrik;
        $new->alamat = $request->alamat_pabrik;
    $new->email = $request->email;
        $new->no_telepon = $request->nomor_telepon;
        $new->save();
        $update_user = User::find($id);
        $update_user->pabrik_id = $new->id;
        $update_user->save();
        $new_payment = new Payment;
        $new_payment->pabrik_id = $new->id;
        $new_payment->amount = 94000;
        $new_payment->invoiceNumber = 'PBRK-' . time() . '-' . $new->id;
        $new_payment->created_at = now();
        $new_payment->updated_at = now();
        $new_payment->save();
        Auth::login($update_user);
        $request->session()->regenerate();
        return redirect()->route('admin.index');
    }
    public function store_req(Request $request){
        $request->validate([
            'pabrik_id' => 'required',


        ]);
        $user_id = Auth::getUser()->id;

        $new= new \App\Models\Request;
        $new->user_id = $user_id;
        $new->pabrik_id = $request->pabrik_id;
        $new->save();
        Auth::logout();
        return redirect()->route('login')->with('berhasil','Permohonan anda telah dikirim, silahkan tunggu konfirmasi dari admin');

    }
    public function succes_payment(){
        $judul = "payment|success";
        return view('payment.berhasil',compact('judul'));
    }
    public function gagal_payment(){
        $judul = "payment|failed";
        return view('payment.gagal',compact('judul'));
    }
}
