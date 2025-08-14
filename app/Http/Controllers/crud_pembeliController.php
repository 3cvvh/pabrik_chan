<?php

namespace App\Http\Controllers;

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
          $query = pembeli::with('pabrik');

        // Filter by search keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%")
                  ->orWhere('no_telepon', 'like', "%$search%");
            });
        }

        // Filter by pabrik
        if ($request->filled('pabrik_filter')) {
            $query->where('id_pabrik', $request->pabrik_filter);
        }

        $pembeli = $query->get();

        return view('admin.pembeli',[
            'judul' => 'gudang|page',
            'pembeli' => $pembeli,
            'pabrik' => pabrik::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form_pembeli',[
            'judul' => 'Tambah pembeli',
            'pabrik' => pabrik::all()
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
        return redirect('/dashboard/admin/pembeli')->with('tambah','berhasil menambahkan data');
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
        $pembeli = pembeli::findOrFail($id);
        return view('admin.form_pembeli_edit', [
            'judul' => 'Edit pembeli',
            'pembeli' => $pembeli,
            'pabrik' => pabrik::all()
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

        return redirect('/dashboard/admin/pembeli')->with('edit','berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,Request $request)
    {
        $pabrik =  pembeli::find($id);
        pembeli::destroy($request->id);
        return redirect('/dashboard/admin/pembeli')->with('hapus', 'Data berhasil dihapus');
    }
}
