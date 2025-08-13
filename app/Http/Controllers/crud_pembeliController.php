<?php

namespace App\Http\Controllers;

use App\Models\pembeli;
use Illuminate\Http\Request;

class Crud_pembeliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $pembeli = pembeli::all();
        return view('admin.pembeli', [
            'judul' => 'Pembeli',
            'pembeli' => $pembeli
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form_pembeli',[
            'judul' => 'Tambah pembeli',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datavalid = $request->validate([
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
        return view('admin.form_pembeli_edit', [
            'judul' => 'Edit Pabrik',
            'pembeli' => pembeli::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pabrik = pembeli::find($id);
   $dataedit = $request->validate([
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
