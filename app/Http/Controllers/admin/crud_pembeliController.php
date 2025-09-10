<?php

namespace App\Http\Controllers\admin;

use App\Models\pembeli;
use App\Models\pabrik;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Crud_pembeliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
          $data = pembeli::with('pabrik')->where('id_pabrik',Auth::user()->pabrik_id);

        // Filter by search keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $data->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%")
                  ->orWhere('no_telepon', 'like', "%$search%");
            });
        }

        // Filter by pabrik
        if ($request->filled('pabrik_filter')) {
            $data->where('id_pabrik', $request->pabrik_filter);
        }

        return view('admin.crud_pembeli.pembeli',[
            'judul' => 'pembeli|page',
            'data'  => $data->latest()->paginate(3),
            'pabrik' => pabrik::all()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $id_pabrik_pengguna = Auth::user()->pabrik_id;

        $pabrik_terkait = Pabrik::find($id_pabrik_pengguna);
        return view('admin.crud_pembeli.form_pembeli',[
            'judul' => 'Tambah pembeli',
            'pabrik' => $pabrik_terkait
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datavalid = $request->validate([
            'id_pabrik' => 'required',
            'name' => ['required','max:80'],
            'alamat' => ['required'],
            'no_telepon' => ['required','min:9']
        ]);
        pembeli::create($datavalid);
        return redirect('/dashboard/admin/crud_pembeli')->with('berhasil','berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(pembeli $pembeli)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id_pabrik_pengguna = Auth::user()->pabrik_id;
        $pabrik_terkait = Pabrik::find($id_pabrik_pengguna);
        $pembeli = pembeli::findOrFail($id);
        return view('admin.crud_pembeli.form_pembeli_edit', [
            'judul' => 'Edit pembeli',
            'pembeli' => $pembeli,
            'pabrik' => $pabrik_terkait
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pembeli = pembeli::find($id);
   $dataedit = $request->validate([
            'id_pabrik' => 'required',
            'name' => ['required','max:80'],
            'alamat' => ['required'],
            'no_telepon' => ['required','min:9']
        ]);
        pembeli::where('id', $request->id)->update($dataedit);

        return redirect('/dashboard/admin/crud_pembeli')->with('berhasil','berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,Request $request)
    {
        $pabrik =  pembeli::find($id);
        pembeli::destroy($request->id);
        return redirect('/dashboard/admin/crud_pembeli')->with('berhasil', 'Data berhasil dihapus');
    }
}
