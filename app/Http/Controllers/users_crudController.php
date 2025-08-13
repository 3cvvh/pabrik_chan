<?php

namespace App\Http\Controllers;

use App\Models\pabrik;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Users_crudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $data = User::with(['pabrik', 'role'])
    ->where('id','!=',Auth::user()->id)
    ->latest();

    if($request->has('search') || $request->has('roles_key')){
        $data = User::query()
            ->where('id', '!=', Auth::user()->id)
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

    return view('super_admin.crud_user.index',[
        'judul' => 'user|list',
        'data' => $data->get(),
        'role' => role::where('id', '!=', 4)->get(),
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.crud_user.form_tambahUser', [
            'judul' => 'user|tambah',
            'roles' => role::where('id', '!=', 4)->get(),
            'pabrik' => \App\Models\Pabrik::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
            'pabrik_id' => 'required',
            'alamat' => 'required',
        ]);
        User::create($data);
        return redirect('/dashboard/super_admin/crud_users')->with('tambah','berhasil menambah data');
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
    public function edit($id)
    {
        return view('super_admin.crud_user.edit',[
            'data' => user::find($id),
            'pabriks' => pabrik::all(),
            'roles' => role::where('id', '!=','4' )->get(),
            'judul' => User::find($id)->name
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $databaru = $request->validate([
            'name' => ['required'],
            'email' => ['email:dns','required'],
            'role_id' => 'required|integer',
            'pabrik_id' => 'required|integer',
            'alamat' => 'required',
        ]);
        if(!$request->password){
            $user_old_pw = User::find($id);
            $databaru['password'] =  $user_old_pw->password;
        }else{
            $databaru['password'] = Hash::make($request->password);
        }
        User::where('id', '=',$id)->update($databaru);
        return redirect()->route('crud_users.index')->with('edit','berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/dashboard/super_admin/crud_users')->with('hapus','berhasil menghapus data user');
    }
}
