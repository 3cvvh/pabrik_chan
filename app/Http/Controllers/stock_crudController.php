<?php

namespace App\Http\Controllers;

use App\Models\stock_produk;
use Illuminate\Http\Request;

class stock_crudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orang_gudang.produk',[
            'judul' => 'Produk|stock',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(stock_produk $stock_produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(stock_produk $stock_produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, stock_produk $stock_produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(stock_produk $stock_produk)
    {
        //
    }
}
