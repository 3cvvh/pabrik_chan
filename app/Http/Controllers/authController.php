<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    public function login(){
        return view('login',[
            'judul' => 'login|page'
        ]);
    }
    public function store(Request $request){
        $datavalid = $request->validate([
            'email' => 'required',
            'password' => 'required|min:5'
        ]);
        if(Auth::attempt($datavalid)){
            if(Auth::getUser()->role_id == 1){
                $request->session()->regenerate();
                return redirect()->intended(route('admin.index'));
            }elseif(Auth::getUser()->role_id == 2){
                $request->session()->regenerate();
                return redirect()->intended(route('orang_gudang.index'));
            }elseif(Auth::getUser()->role_id == 3){
                $request->session()->regenerate();
                return redirect()->intended(route('owner.index'));
            }else{
                $request->session()->regenerate();
                return redirect()->intended(route('super.index'));
            }
        }
        return back()->with('gagal','password atau email salah!!');
    }
    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
