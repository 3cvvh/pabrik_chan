<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\authController;
use App\Http\Controllers\crud_pabrikController;
use App\Http\Controllers\orang_gudangController;
use App\Http\Controllers\ownerController;
use App\Http\Controllers\stock_crudController;
use App\Http\Controllers\user_crudController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\super_beatriceController;

//daftar route Jika user belum login
Route::middleware(['guest'])->group(function(){
    Route::get('/',[authController::class,'login'])->name('login');
    Route::post('/',[authController::class,'store'])->name('login.store');
});
//daftar route jika user sudah login sebagai admin
Route::middleware(['beatrice','admin'])->group(function () {
    Route::get('/dashboard/admin',[adminController::class,'index'])->name('admin.index');
    Route::resource('/dashboard/admin/crud_user', user_crudController::class);
    Route::get('/dashboard/admin/crud_pabrik',[crud_pabrikController::class,'index'])->name('crud_pabrik.index');
    Route::resource('/dashboard/admin/crud_pabrik',crud_pabrikController::class);
});

//daftar route jika user sudah login sebagai orang gudang
Route::middleware(['beatrice','orang_gudang'])->group(function () {
    Route::get('/dashboard/org_gudang',[orang_gudangController::class,'index'])->name('orang_gudang.index');
    Route::resource('/dashboard/org_gudang/stock',stock_crudController::class);
});
//daftar route jika user sudah login sebagai owner
Route::middleware(['beatrice','owner'])->group(function () {
    Route::get('/dashboard/owner',[ownerController::class,'index'])->name('owner.index');
    Route::get('/dashboard/owner/generatelaporan', [ownerController::class, 'generateLaporan'])->name('owner.generatelaporan');
});
//daftar route jika user sudah login sebagai super admin
Route::middleware(['beatrice','beatricekawaii'])->group(function () {
    Route::get('/dashboard/super_admin',[super_beatriceController::class, 'index'])->name('super.index');
});
//logout
Route::post('/logout',[authController::class,'logout'])->name('logout');
