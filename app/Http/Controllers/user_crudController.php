<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class user_crudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('pabrik_id', Auth::user()->pabrik_id)->get();
        return view('admin.crud_user', [
        'judul' => 'crud user',
        'data_user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form_user',[
            'judul' => 'form tambah user'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'required',
            'pabrik' => 'required',
            'role' => 'required',
        ]);
        User::create($request -> all());

        return redirect()->route('crud_user.index')->with('success', 'user berhasil di tamabahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
         return view('admin.form_user',[
            'judul' => 'form edit user'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
         $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'required',
            'pabrik' => 'required',
            'role' => 'required',
        ]);
        User::update($request -> all());
        return redirect()->route('crud_user.index')->with('success', 'user berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
