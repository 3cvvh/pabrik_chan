<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\owner\ownerController;
use App\Http\Controllers\admin\crud_gudangController;
use App\Http\Controllers\admin\user_crudController;
use App\Http\Controllers\admin\crudProdukController;
use App\Http\Controllers\super_admin\users_crudController;
use App\Http\Controllers\super_admin\crud_pabrikController;
use App\Http\Controllers\admin\crud_pembeliController;
use App\Http\Controllers\orang_gudang\Crud_stock_produk2Controller;
use App\Http\Controllers\admin\Crud_stock_produkController;
use App\Http\Controllers\orang_gudang\orang_gudangController;
use App\Http\Controllers\admin\crud_transaksiController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\orang_gudang\CrudProduk2Controller;
use App\Http\Controllers\super_admin\super_beatriceController;
use App\Http\Controllers\GuestController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\admin\RequestController;

//daftar route Jika user belum login
Route::middleware(['beatrice'])->group(function(){
    Route::get('/',[AuthController::class,'login'])->name('login');
    Route::post('/',[AuthController::class,'store'])->name('login.store');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
    Route::get('/register',[AuthController::class,'sign'])->name('register');
    Route::post('/register',[AuthController::class,'signlogic'])->name('register.store');
});
//daftar route jika user sudah login sebagai admin
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard/admin',[adminController::class,'index'])->name('admin.index');
    Route::resource('/dashboard/admin/crud_user', user_crudController::class)->except('show')->middleware(["not_paid"]);
    Route::resource('/dashboard/admin/crud_transaksi', Crud_transaksiController::class)->middleware(['not_paid']);
    Route::resource('/dashboard/admin/crud_user', user_crudController::class)->middleware(['not_paid']);
    Route::resource('/dashboard/admin/crud_pembeli', crud_pembeliController::class)->except('show')->middleware(['not_paid']);
    Route::resource('/dashboard/admin/crud_gudang', crud_gudangController::class)->except('show')->middleware(['not_paid']);
    Route::resource('/dahboard/admin/Stock_produk', Crud_stock_produkController::class)->middleware(['not_paid']);
    Route::post('/dashboard/admin/tanggal/{transaksi:id}',[AdminController::class, 'tanggal'])->name('admin.tanggal')->middleware(['not_paid']);
    Route::post('dashboard/admin/produk/{Detail_transaksi:id}',[AdminController::class, 'produk'])->name('admin.produk')->middleware(['not_paid']);
    Route::post('/dashboard/admin/hapus/{Detail_transaksi:id}',[adminController::class,'hapus_produk'])->name('admin-hapus')->middleware(['not_paid']);
    Route::get('/dashboard/admin/generate_report/{transaksi:id}',[AdminController::class, 'generateReport'])->name('admin.laporan')->middleware(['not_paid']);
    Route::get('/dashboard/admin/crud_produk/scanner', [crudProdukController::class, 'scanner'])->name('admin.produk.scanner')->middleware(['not_paid']);
    Route::post('/dashboard/admin/crud_produk/scanner', [crudProdukController::class, 'scannerProcess'])->name('admin.produk.scanner.process')->middleware(['not_paid']);
    Route::get('/dashboard/admin/produk/{produk}/download-qr', [crudProdukController::class, 'qrDownload'])->name('produk.qrDownload')->middleware(['not_paid']);
    Route::get('/dashboard/admin/produk/{produk}/qr-view', [crudProdukController::class, 'qrView'])->name('produk.qrView')->middleware(['not_paid']);
    Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::resource('/dashboard/admin/Request',RequestController::class)->except(['index']);

});
//daftar route jika user sudah login sebagai orang gudang
Route::middleware(['orang_gudang'])->group(function () {
    Route::get('/dashboard/org_gudang',[orang_gudangController::class,'index'])->name('orang_gudang.index');
    Route::get('/dashboard/org_gudang/produk/scanner', [CrudProduk2Controller::class, 'scanner'])->name('orang_gudang.produk.scanner')->middleware(['not_paid']);
    Route::post('/dashboard/org_gudang/produk/scanner', [CrudProduk2Controller::class, 'scannerProcess'])->name('orang_gudang.produk.scanner.process')->middleware(['not_paid']);
    Route::resource('/dashboard/org_gudang/crud_stocks',Crud_stock_produk2Controller::class)->middleware(['not_paid']);
    Route::resource('/dashboard/org_gudang/crud_produk',CrudProduk2Controller::class)->except(['create','store','destroy','edit','update'])->middleware(["not_paid"]);
    Route::get('/dashboard/org_gudang/produk/{produk}/download-qrs', [crudProdukController::class, 'qrDownload'])->name('produk.qrDownloads')->middleware(['not_paid']);
    Route::get('/dashboard/org_gudang/produk/{produk}/qr-views', [crudProdukController::class, 'qrView'])->name('produk.qrViews')->middleware(['not_paid']);

});
//daftar route jika user sudah login sebagai owner
Route::middleware(['owner'])->group(function () {
    Route::get('/dashboard/owner',[ownerController::class,'index'])->name('owner.index')->middleware(['not_paid']);
    Route::get('/dashboard/owner/generatelaporan', [ownerController::class, 'generateLaporan'])->name('owner.generatelaporan')->middleware(['not_paid']);
    Route::get('/dashboard/owner/generate/{transaksi:id}',[AdminController::class, 'generateReport'])->name('owner.laporan')->middleware(['not_paid']);
    Route::resource('/dashboard/owner/transaksi',crud_transaksiController::class)->except(['create','store','destroy','edit','update'])->middleware(['not_paid']);
    Route::get('/dashboard/owner/dawgboard',[OwnerController::class, 'dashboard'])->name('owner.dash');
    Route::get('/dashboard/owner/laporanbos',[OwnerController::class, 'laporanbos'])->name('owner.laporanbos')->middleware(['not_paid']);
});
//daftar route jika user sudah login sebagai super admin
Route::middleware(['beatricekawaii'])->group(function () {
    Route::resource('/dashboard/super_admin/crud_pabrik',crud_pabrikController::class);
    Route::resource('/dashboard/super_admin/crud_users',users_crudController::class)->except('show');
    Route::get('/dashboard/super_admin',[super_beatriceController::class, 'index'])->name('super.index');
});
//org_gudang dan admin
Route::middleware(['org_gudang/admin'])->group(function(){
    Route::resource('/dashboard/admin/produk',crudProdukController::class)->middleware(["not_paid"]);
});
//khusus akun guest(yang belum di konfirmasi)
Route::middleware(['guest'])->group(function(){
    Route::get('/guest/welcome',[GuestController::class,'index'])->name('guest.index');
    Route::get('/guest/form_pabrik',[GuestController::class,'form_pabrik'])->name('guest.form_pabrik');
    Route::get('/guest/request_pabrik',[GuestController::class,'request'])->name('guest.request_pabrik');
    Route::post('/guest/form_pabrik/store/{user:id}',[GuestController::class, 'store_pabrik'])->name('guest.storePabrik');
    Route::post('/guest/request/store',[GuestController::class,'store_req'])->name('guest.store_req');
});
//logout
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

