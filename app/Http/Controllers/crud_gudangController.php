<?php

namespace App\Http\Controllers;

use App\Models\pabrik;
use App\Models\gudang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Crud_gudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = gudang::with(['pabrik']);

        // Filter berdasarkan pabrik jika ada
        if ($request->filled('pabrik_filter')) {
            $query->where('id_pabrik', $request->pabrik_filter);
        }

        // Filter berdasarkan search (nama/alamat/no_telepon/keterangan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%")
                  ->orWhere('no_telepon', 'like', "%$search%")
                  ->orWhere('keterangan', 'like', "%$search%");
            });
        }

        // Optional: urutkan terbaru
        $gudang = $query->orderBy('id', 'desc')->get();

        return view('admin.crud_gudang.gudang',[
            'judul' => 'gudang|page',
            'gudang' => $gudang,
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


        return view('admin.crud_gudang.create_gudang', [
            'judul' => 'Tambah Gudang',
            'pabrik' => $pabrik_terkait // <-- Sekarang $pabrik adalah OBJEK MODEL tunggal
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pabrik' => 'required',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        gudang::create($validated);

        return redirect('/dashboard/admin/crud_gudang')->with('tambah', 'Gudang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(gudang $gudang)
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
        $gudang = Gudang::with('pabrik')->findOrFail($id);
        return view('admin.crud_gudang.edit_gudang', [
            'judul' => 'Edit Gudang',
            'gudang' => $gudang,
            'pabrik' => $pabrik_terkait
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $gudang= gudang::find($id);
        $validated = $request->validate([
            'id_pabrik' => 'required',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
            'status' => 'required',
        ]);

        gudang::where('id', $id)->update($validated);

        return redirect('/dashboard/admin/crud_gudang')->with('edit', 'Gudang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $gudang = gudang::find($id);
        gudang::destroy($request->id);
        return redirect('/dashboard/admin/crud_gudang')->with('hapus', 'Gudang berhasil dihapus');
    }
}

