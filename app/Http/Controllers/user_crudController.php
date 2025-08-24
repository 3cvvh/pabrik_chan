<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\User;
use App\Models\Role;
use App\Models\Pabrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class User_crudController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {
        $query = User::where('pabrik_id', Auth::user()->pabrik_id);
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $data_user = $query->get();
        return view('admin.crud_user', [
            'judul' => 'crud user',
            'data_user' => $data_user
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('id','!=',4)->get();
        $pabriks = Pabrik::all();
        return view('admin.form_user', [
            'judul' => 'form tambah user',
            'roles' => $roles,
            'pabriks' => $pabriks,
            'gudang' => Gudang::where('id_pabrik', Auth::user()->pabrik_id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'required|string|max:255',
            'pabrik_id' => 'required|exists:pabriks,id',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:5|confirmed',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password), // hash password!
            'alamat'    => $request->alamat,
            'pabrik_id' => $request->pabrik_id,
            'role_id'   => $request->role_id,
        ]);
        if($request->gudang_id){
            $user = User::where('email',$request->email)->first();
            $user->gudang_id = $request->gudang_id;
            $user->save();
        }

        return redirect()->route('crud_user.index')->with('success', 'User berhasil ditambahkan');
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
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if($user->pabrik_id != Auth::user()->pabrik_id){
            abort(404);
        }
        $roles = Role::where('id','!=',4);
        $pabriks = Pabrik::all();
        return view('admin.form_user', [
            'judul' => 'form edit user',
            'user' => $user,
            'roles' => $roles->get(),
            'pabriks' => $pabriks,
            'gudang' => Gudang::where('id_pabrik', Auth::user()->pabrik_id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $crud_user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $crud_user->id,
            'alamat' => 'required',
            'pabrik_id' => 'required|exists:pabriks,id',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        // Update password jika diisi
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        } else {
            unset($validatedData['password']);
        }
        if($request->gudang_id){
            $crud_user->gudang_id = $request->gudang_id;
            $crud_user->save();
        }
        $crud_user->update($validatedData);
        return redirect()->route('crud_user.index')->with('success', 'user berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $crud_user = User::findOrFail($id);
        $crud_user->delete();
        return redirect()->route('crud_user.index')->with('success', 'user berhasil di hapus');
    }
}
