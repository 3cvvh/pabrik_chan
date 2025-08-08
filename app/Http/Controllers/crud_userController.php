<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class crud_userController extends ControllerResolver
{
    public function index(){
        return view('admin.crud_user',[
            'judul' => 'admin/crud_user',
        ]);
    }
}