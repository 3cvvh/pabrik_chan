<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use mysqli;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login',[
            'judul' => 'login|page'
        ]);
    }
    public function store(Request $request){
        $datavalid = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $remember = $request->has('remember') ? true : false;
        if(Auth::attempt($datavalid,$remember)){
            if(Auth::getUser()->pabrik_id == null){
                $request->session()->regenerate();
                return redirect()->intended(route('guest.index'));
            }
            if(Auth::getUser()->role_id == 1){
                $request->session()->regenerate();
                return redirect()->intended(route('admin.index'));
            }elseif(Auth::getUser()->role_id == 2){
                $request->session()->regenerate();
                return redirect()->intended(route('orang_gudang.index'));
            }elseif(Auth::getUser()->role_id == 3){
                $request->session()->regenerate();
                return redirect()->intended(route('owner.dash'));
            }else{
                $request->session()->regenerate();
                return redirect()->intended(route('super.index'));
            }
        }
        if(!Auth::attempt($datavalid)){
            $attempts = session('percobaan',0) + 1;
            session(['percobaan' => $attempts]);
              return back()->with('gagal','password atau email salah!!');
        }
        session()->forget('percobaan');
    }
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'))->with('out', 'Berhasil logout!');
    }
    public function sign(){
        return view('auth.register',[
            "judul" => 'register|page',
        ]);
    }
    public function signlogic(Request $request){
        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
    $newUser = new \App\Models\User;
    $newUser->name = $request->nama;
    $newUser->email = $request->email;
    $newUser->password = bcrypt($request->password);
    $newUser->role_id = 1;
    $newUser->save();
    return redirect(route('login'))->with('berhasil', 'Registrasi berhasil! Silakan login.');
    }
}
