<?php

namespace App\Http\Controllers\super_admin;

use App\Models\role;
use App\Models\User;
use App\Models\Gudang;
use App\Models\pabrik;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Users_crudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $pabrikId = Auth::user()->pabrik_id;

    $query = User::with(['pabrik', 'role'])
        ->where('id','!=', Auth::id())
        ->where('role_id', 1) // Hanya ambil user dengan role_id 1
        ->when($pabrikId, function($q) use ($pabrikId) {
            $q->where('pabrik_id', $pabrikId);
        })
        ->latest();

    // tambahkan filter search / role pada query yang sama (jangan reset $query)
    if ($request->filled('search') || $request->filled('roles_key')) {
        $query->when($request->search, function($q) use ($request) {
            $q->where(function($sub) use ($request) {
                $sub->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        });

        $query->when($request->roles_key, function($q) use ($request) {
            $q->where('pabrik_id', $request->roles_key);
        });
    }

    if ($request->wantsJson() || $request->ajax()) {
        $users = $query->get()->map(function($u){
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role_name' => $u->role->name ?? '',
                'pabrik_name' => $u->pabrik->name ?? '',
            ];
        });
        return response()->json($users);
    }


    return view('super_admin.crud_user.index',[
        'judul' => 'user|list',
        'data' => $query->get(),
        'role' => role::where('id', 1)->get(),
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.crud_user.form_tambahUser', [
            'judul' => 'user|tambah',
            'pabrik' => \App\Models\Pabrik::all(),
            'gudang' => Gudang::all(),
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
            'password' => 'required|min:8',
            'role_id' => 'required',
            'pabrik_id' => 'required',
            'alamat' => 'required',
        ]);
        $data['role_id'] = 1;
        User::create($data);
        return redirect('/dashboard/super_admin/crud_users')->with('berhasil','berhasil menambah data');
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
            'judul' => User::find($id)->name,
            'gudang' => Gudang::where('id_pabrik',User::find($id)->pabrik_id)->get(),
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
            'password' => ['nullable','min:8'],
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
        return redirect()->route('crud_users.index')->with('berhasil','berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/dashboard/super_admin/crud_users')->with('berhasil','berhasil menghapus data user');
    }
}
