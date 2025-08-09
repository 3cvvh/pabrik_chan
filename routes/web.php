<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\PabrikController;
use App\Http\Controllers\authController;
use App\Http\Controllers\crud_userContoller;
use App\Http\Controllers\crud_pabrikController;
use App\Http\Controllers\orang_gudangController;
use App\Http\Controllers\ownerController;
use App\Http\Controllers\user_crudController;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
=======
use App\Http\Controllers\super_beatriceController;
use App\Http\Controllers\users_crudController;
>>>>>>> 3da629ff44690280260bc4820385a723b2661ed1

//daftar route Jika user belum login
Route::middleware(['guest'])->group(function(){
    Route::get('/',[authController::class,'login'])->name('login');
    Route::post('/',[authController::class,'store'])->name('login.store');
});
//daftar route jika user sudah login sebagai admin
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/admin',[adminController::class,'index'])->name('admin.index');
    Route::resource('/dashboard/admin/crud_user', user_crudController::class);
<<<<<<< HEAD
    Route::resource('/dashboard/admin/crud_pabrik',crud_pabrikController::class);
=======
>>>>>>> 3da629ff44690280260bc4820385a723b2661ed1
});

//daftar route jika user sudah login sebagai orang gudang
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/org_gudang',[orang_gudangController::class,'index'])->name('orang_gudang.index');
});
//daftar route jika user sudah login sebagai owner
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/owner',[ownerController::class,'index'])->name('owner.index');
<<<<<<< HEAD
=======
    Route::get('/dashboard/owner/generatelaporan', [ownerController::class, 'generateLaporan'])->name('owner.generatelaporan');
});
//daftar route jika user sudah login sebagai super admin
Route::middleware(['beatrice','beatricekawaii'])->group(function () {
    Route::resource('/dashboard/super_admin/crud_pabrik',crud_pabrikController::class);
    Route::resource('/dashboard/super_admin/crud_user',users_crudController::class);
    Route::get('/dashboard/super_admin',[super_beatriceController::class, 'index'])->name('super.index');
>>>>>>> 3da629ff44690280260bc4820385a723b2661ed1
});
//logout
Route::post('/logout',[authController::class,'logout'])->name('logout');