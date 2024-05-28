<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::GROUP(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
    Route::GET('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::GET('logout', [AdminController::class, 'logout'])->name('auth.logout');
});

Route::GROUP(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
    Route::GET('login', [AdminController::class, 'show'])->name('auth.login.show');
    Route::POST('login', [AdminController::class, 'login'])->name('auth.login');
});

Route::FALLBACK(function() {
    return redirect()->route('auth.login.show');
});
