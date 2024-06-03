<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\ComplexController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserTypeController;
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
    // DASHBOARD
    Route::GET('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::GET('logout', [AdminController::class, 'logout'])->name('auth.logout');

    // USER ROLES
    Route::GET('role', [UserTypeController::class, 'index'])->name('usertype.index');
    Route::GET('roles', [UserTypeController::class, 'role'])->name('usertype.roles');
    Route::POST('roles', [UserTypeController::class, 'insert'])->name('usertype.insert');

    //COMPLEX
    Route::GET('complex', [ComplexController::class, 'index'])->name('complex.index');
    Route::GET('insert', [ComplexController::class, 'complex'])->name('complex.show');
    Route::POST('insert', [ComplexController::class, 'insert'])->name('complex.insert');
    Route::POST('update-complex-status', [ComplexController::class, 'updateStatus']);
    Route::GET('update/{id?}', [ComplexController::class, 'showUpdate'])->name('complex.update.show');
    Route::POST('update/{id?}', [ComplexController::class, 'update'])->name('complex.update');

    //HEALTH COACH
    Route::GET('coach', [CoachController::class, 'index'])->name('coach.index');
    Route::GET('insert-coach', [CoachController::class, 'show'])->name('coach.show.insert');
    Route::POST('insert-coach', [CoachController::class, 'insert'])->name('coach.insert');
});

Route::GROUP(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
    Route::GET('login', [AdminController::class, 'show'])->name('auth.login.show');
    Route::POST('login', [AdminController::class, 'login'])->name('auth.login');
});

Route::FALLBACK(function() {
    return redirect()->route('auth.login.show');
});
