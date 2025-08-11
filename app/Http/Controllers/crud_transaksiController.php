<?php

namespace App\Http\Controllers;

use App\Models\pembeli;
use App\Models\produk;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use statustransaksi;

class crud_transaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $t = transaksi::with(['pembeli','pabrik'])->where('id_pabrik','=',Auth::user()->pabrik_id);
        return view('admin.crud_transaksi.index',[
            'judul' => 'transaksi|page',
            'data' => $t->get(),
            'pembeli' => pembeli::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud_transaksi.create', [
            'judul' => 'transaksi|create',
            'pembeli' => pembeli::all(),
            'produk' => produk::where('id_pabrik', Auth::user()->pabrik_id)->get(),
        ]);
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
    public function show(transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }
}
