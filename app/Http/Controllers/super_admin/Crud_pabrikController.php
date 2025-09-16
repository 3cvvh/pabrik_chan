<?php

namespace App\Http\Controllers\super_admin;

use App\Models\pabrik;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class Crud_pabrikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $data = pabrik::query(); // kayak di produk, cuma ganti model

    // kalau ada search
    if ($request->filled('search')) {
        $search = trim($request->search);
        $data->where('name', 'LIKE', '%' . $search . '%')
             ->orWhere('alamat', 'LIKE', '%' . $search . '%');
    }

    return view('super_admin.crud_pabrik.pabrik', [
        'judul' => 'Pabrik',
        'data' => $data->latest()->paginate(3), // sama kayak produk kamu (paginate)
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.crud_pabrik.form_pabrik',[
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
            'no_telepon' => ['required','min:9'] ,
            'gambar' =>['image']
        ]);
        if($request->file('gambar')){
            $datavalid['gambar'] = $request->file('gambar')->store('pabriks-img');
        }
        pabrik::create($datavalid);
        return redirect('/dashboard/super_admin/crud_pabrik')->with('berhasil','berhasil menambahkan data');
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
    public function edit($id)
    {
        return view('super_admin.crud_pabrik.form_pabrik_edit', [
            'judul' => 'Edit Pabrik',
            'pabrik' => pabrik::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pabrik = pabrik::find($id);
   $dataedit = $request->validate([
            'name' => ['required','max:80'],
            'alamat' => ['required'],
            'no_telepon' => ['required','min:9'],
            'gambar' => ['image']
        ]);
        if($request->gambar){
            if($pabrik->gambar == true){
                Storage::delete($pabrik->gambar);
            }
            $dataedit['gambar'] = $request->file('gambar')->store('pabriks-img');
        }
        // Panggil metode update() pada instance model $pabrik yang sudah disediakan
        pabrik::where('id', $request->id)->update($dataedit);

        return redirect('/dashboard/super_admin/crud_pabrik')->with('edit','berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,Request $request)
    {
        $pabrik =  pabrik::find($id);
        if($pabrik->gambar){
            Storage::delete($pabrik->gambar);
        }
       pabrik::destroy($request->id);
        return redirect('/dashboard/super_admin/crud_pabrik')->with('hapus', 'Data berhasil dihapus');
}
}
