<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\AlluserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth', 'ceklevel:admin,teknisi,kasir,alluser'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'ceklevel:admin'])->group(function () {
    Route::resource('/admin', AdminController::class);
    Route::resource('/teknisi', TeknisiController::class);
    Route::resource('/kasir', KasirController::class);
    Route::resource('/alluser', AlluserController::class);
    Route::resource('/kategori', CategoryController::class);
});

Route::middleware(['auth', 'ceklevel:admin,kasir,teknisi'])->group(function () {
    Route::resource('/pesanan', OrderController::class);
    Route::resource('/nota', ReceiptController::class);
});

Route::middleware(['auth', 'ceklevel:admin,teknisi'])->group(function () {
    Route::post('/pesanan/fix/{id}', [OrderController::class, 'fix'])->name('pesanan.fix');
});

Route::middleware(['auth', 'ceklevel:admin,kasir'])->group(function () {
    Route::get('/nota/cetak/{id}', [ReceiptController::class, 'cetakNota'])->name('nota.cetak');
    Route::post('/nota/pelunasan/{id}', [ReceiptController::class, 'pelunasan'])->name('nota.pelunasan');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
