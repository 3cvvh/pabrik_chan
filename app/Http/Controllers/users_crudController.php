<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class users_crudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with(['pabrik', 'role'])->latest();
        if(request()->has('search')){
            $data = User::where('name', 'like', '%'.request()->search.'%')
                        ->orWhere('email', 'like', '%'.request()->search.'%')
                        ->with(['pabrik', 'role'])
                        ->latest();
        }
        return view('super_admin.crud_user.index',[
            'judul' => 'user|list',
            'data' => $data->get()
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
