<?php

use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard/admin',[adminController::class, 'index'])->name('admin.dashboard');
Route::get('/', function () {
    return view('login');
});
