<?php

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\TransactionController::class, 'index']);
Route::get('/wallet', [App\Http\Controllers\TransactionController::class, 'getWallet']);
Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'getTransaction']);
Route::resource('/transaction', App\Http\Controllers\TransactionController::class);
Route::delete('/transaction/softDelete/{id}', [App\Http\Controllers\TransactionController::class, 'softDelete']);

Route::resource('/transfer', App\Http\Controllers\WalletController::class);
Route::delete('/transfer/softDelete/{id}', [App\Http\Controllers\WalletController::class, 'softDelete']);

Route::get('/profile', [App\Http\Controllers\UserController::class, 'index']);

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
