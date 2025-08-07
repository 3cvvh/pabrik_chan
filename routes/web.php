<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\authController;
use App\Http\Controllers\orang_gudangController;
use App\Http\Controllers\ownerController;
use App\Http\Controllers\stock_crudController;
use Illuminate\Support\Facades\Route;

//daftar route Jika user belum login
Route::middleware(['guest'])->group(function(){
    Route::get('/',[authController::class,'login'])->name('login');
    Route::post('/',[authController::class,'store'])->name('login.store');
});
//daftar route jika user sudah login sebagai admin
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/admin',[adminController::class,'index'])->name('admin.index');
});
//daftar route jika user sudah login sebagai orang gudang
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/org_gudang',[orang_gudangController::class,'index'])->name('orang_gudang.index');
    Route::resource('/dashboard/org_gudang/stock',stock_crudController::class);
});
//daftar route jika user sudah login sebagai owner
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/owner',[ownerController::class,'index'])->name('owner.index');
    Route::get('/dashboard/owner/generatelaporan', [ownerController::class, 'generateLaporan'])->name('owner.generatelaporan');
});
//logout
Route::post('/logout',[authController::class,'logout'])->name('logout');