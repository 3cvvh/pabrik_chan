<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check() == false){
            abort(403,'Unauthorized');
        }
        $data = Auth::user();
        $judul = "Profile " . $data->name;
        return view('profile.index',compact('judul','data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
         $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'gambar' => 'nullable|image',
            'email' => 'required',
            'alamat' => 'required',
        ]);
        if($request->hasFile('gambar')){
            if($user->profile_picture_path){
                Storage::disk("public")->delete($user->profile_picture_path);
            }
            $user->profile_picture_path = $request->file('gambar')->store('profile-pictures','public');
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = $request->password == true ? bcrypt($request->password) : $user->password;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->save();
        return redirect()->route('user.index')->with('berhasil','berhasil mengupdate data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
    public function changepass(Request $request,User $user){
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ],
        [
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password.min' => 'Password minimal 8 karakter',
        ]);
        if(!Hash::check($request->current_password, $user->password)){
            return back()->with('gagal','Password saat ini tidak sesuai');
        }
        $user->password = bcrypt($request->new_password);
        $user->save();
        return redirect()->route('user.index')->with('berhasil','berhasil mengupdate password');

    }
}
