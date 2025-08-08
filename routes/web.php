<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\PabrikController;
use App\Http\Controllers\authController;
<<<<<<< HEAD
use App\Http\Controllers\crud_userContoller;
=======
use App\Http\Controllers\crud_pabrikController;
>>>>>>> 7796c11bdc1a6b76fd4b1075e2231cfe440b90ee
use App\Http\Controllers\orang_gudangController;
use App\Http\Controllers\ownerController;
use App\Http\Controllers\user_crudController;
use Illuminate\Support\Facades\Route;

//daftar route Jika user belum login
Route::middleware(['guest'])->group(function(){
    Route::get('/',[authController::class,'login'])->name('login');
    Route::post('/',[authController::class,'store'])->name('login.store');
});
//daftar route jika user sudah login sebagai admin
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/admin',[adminController::class,'index'])->name('admin.index');
<<<<<<< HEAD
    Route::resource('/dashboard/admin/crud_user', user_crudController::class);
=======
    Route::resource('/dashboard/admin/crud_pabrik',crud_pabrikController::class);
>>>>>>> 7796c11bdc1a6b76fd4b1075e2231cfe440b90ee
});

//daftar route jika user sudah login sebagai orang gudang
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/org_gudang',[orang_gudangController::class,'index'])->name('orang_gudang.index');
});
//daftar route jika user sudah login sebagai owner
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/owner',[ownerController::class,'index'])->name('owner.index');
});
//logout
Route::post('/logout',[authController::class,'logout'])->name('logout');