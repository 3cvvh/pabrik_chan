<?php

namespace App\Http\Controllers\admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Gudang;
use App\Models\Pabrik;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class User_crudController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {
    $data = User::with(['pabrik', 'role'])
    ->where('id','!=',Auth::user()->id)
    ->where('role_id','!=',4)
    ->where('pabrik_id',Auth::user()->pabrik_id)
    ->latest();

    if($request->has('search') || $request->has('roles_key')){
        $data = User::query()
            ->where('id', '!=', Auth::user()->id)
            ->where('role_id','!=',4)
            ->where('pabrik_id',Auth::user()->pabrik_id)
            ->when($request->search, function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->search.'%')
                      ->orWhere('email', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->roles_key, function($query) use ($request) {
                $query->where('role_id', $request->roles_key);
            })
            ->with(['pabrik', 'role'])
            ->latest();
    }
        return view('admin.crud_user', [
            'judul' => 'crud user',
            'data' => $data->get(),
            'role' => role::where('id','!=',4)->get(),
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
