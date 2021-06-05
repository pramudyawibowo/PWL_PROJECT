<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TeknisiController;
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
Route::middleware(['auth', 'ceklevel:admin,teknisi,kasir'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'ceklevel:admin'])->group(function () {
    Route::resource('admin', AdminController::class);
});

Route::middleware(['auth', 'ceklevel:teknisi'])->group(function () {
});
Route::middleware(['auth', 'ceklevel:kasir'])->group(function () {
});
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
