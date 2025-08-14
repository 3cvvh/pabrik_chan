<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\ownerController;
use App\Http\Controllers\crud_userContoller;
use App\Http\Controllers\crud_gudangController;
use App\Http\Controllers\user_crudController;
use App\Http\Controllers\crudProdukController;
use App\Http\Controllers\users_crudController;
use App\Http\Controllers\crud_pabrikController;
use App\Http\Controllers\crud_pembeliController;
use App\Http\Controllers\Crud_stock_produkController;
use App\Http\Controllers\orang_gudangController;
use App\Http\Controllers\crud_transaksiController;
use App\Http\Controllers\super_beatriceController;

//daftar route Jika user belum login
Route::middleware(['guest'])->group(function(){
    Route::get('/',[authController::class,'login'])->name('login');
    Route::post('/',[authController::class,'store'])->name('login.store');
});
//daftar route jika user sudah login sebagai admin
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/dashboard/admin',[adminController::class,'index'])->name('admin.index');
    Route::resource('/dashboard/admin/crud_user', user_crudController::class)->except('show');
    Route::resource('/dashboard/admin/crud_transaksi',crud_transaksiController::class);
    Route::resource('/dashboard/admin/crud_user', user_crudController::class);
    Route::resource('/dashboard/admin/pembeli', crud_pembeliController::class)->except('show');
    Route::resource('/dashboard/admin/crud_gudang', crud_gudangController::class)->except('show');
    Route::resource('/dashboard/admin/produk',crudProdukController::class);
    Route::resource('/dahboard/admin/Stock_produk', Crud_stock_produkController::class);
    Route::post('/dashboard/admin/tanggal/{transaksi:id}',[AdminController::class, 'tanggal'])->name('admin.tanggal');
    Route::post('dashboard/admin/produk/{Detail_transaksi:id}',[AdminController::class, 'produk'])->name('admin.produk');
});

//daftar route jika user sudah login sebagai orang gudang
Route::middleware(['auth','orang_gudang'])->group(function () {
    Route::get('/dashboard/org_gudang',[orang_gudangController::class,'index'])->name('orang_gudang.index');
});
//daftar route jika user sudah login sebagai owner
Route::middleware(['auth','owner'])->group(function () {
    Route::get('/dashboard/owner',[ownerController::class,'index'])->name('owner.index');
    Route::get('/dashboard/owner/generatelaporan', [ownerController::class, 'generateLaporan'])->name('owner.generatelaporan');
});
//daftar route jika user sudah login sebagai super admin
Route::middleware(['beatrice','beatricekawaii'])->group(function () {
    Route::resource('/dashboard/super_admin/crud_pabrik',crud_pabrikController::class);
    Route::resource('/dashboard/super_admin/crud_users',users_crudController::class)->except('show');
    Route::get('/dashboard/super_admin',[super_beatriceController::class, 'index'])->name('super.index');
});
//logout
Route::post('/logout',[authController::class,'logout'])->name('logout');
