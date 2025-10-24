<?php

namespace App\Http\Controllers\admin;

use App\Models\Request as modelReq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $req = ModelsRequest::find($id);
        $judul = 'form|penerimaan';
        $role = Role::where('id','!=','4')->get();
        $data_pelamar = $req->get();
        $user = User::find($req->user_id);
        return view('admin.verifikasi.form',compact('judul','role','data_pelamar','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'role' => 'required',
        ],[
            'role.required' => "role harus dipilih"
        ]);
          $req = ModelsRequest::find($id);
         $user = User::find($req->user_id);
        if($request->role == 2){
            $request->validate([
                'gudang_id' => 'required'
            ],[
                'gudang_id.required' => 'jika role orang gudang, gudang harus dipilih'
            ]);
            $user->gudang_id = $request->gudang_id;
        }


       $req->status = 'completed';
       $req->save();
       $user->role_id = $request->role;
       $user->pabrik_id = Auth::getUser()->pabrik_id;
       $user->save();
       return redirect()->route('verifikasi.index')->with('berhasil',"berhasil menerima karyawan");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $req = modelReq::find($id);
        $req->status = "reject";
        $req->deskripsi = request()->reason;
        $req->updated_at = NOW();
        $req->save();
        return redirect()->route('verifikasi.index')->with('berhasil','berhasil menolak');
    }
}
