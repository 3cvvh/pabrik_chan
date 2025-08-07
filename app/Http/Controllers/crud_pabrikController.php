<?php

namespace App\Http\Controllers;

use App\Models\pabrik;
use Illuminate\Http\Request;

class crud_pabrikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pabrik = pabrik::all();
        return view('admin.pabrik', [
            'judul' => 'Pabrik',
            'pabrik' => $pabrik
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form_pabrik',[
            'judul' => 'Tambah Pabrik',
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
        pabrik::create($datavalid);
        return redirect('/dashboard/admin/crud_pabrik')->with('tambah','berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(pabrik $pabrik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pabrik $pabrik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pabrik $pabrik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pabrik $pabrik)
    {
        //
    }
}
