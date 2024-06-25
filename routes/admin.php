<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\ComplexController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserTypeController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PatientParametersController;
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
    Route::GET('view/{id?}', [ComplexController::class, 'view'])->name('complex.view');

    //HEALTH COACH
    Route::GET('coach', [CoachController::class, 'index'])->name('coach.index');
    Route::GET('insert-coach', [CoachController::class, 'show'])->name('coach.show.insert');
    Route::POST('insert-coach', [CoachController::class, 'insert'])->name('coach.insert');
    Route::POST('update-coach-status', [CoachController::class, 'updateStatus']);
    Route::GET('update-coach/{id?}', [CoachController::class, 'showUpdate'])->name('coach.update.show');
    Route::POST('update-coach/{id?}', [CoachController::class, 'update'])->name('coach.update');

    //PATIENT
    Route::GET('patient', [PatientController::class, 'index'])->name('patient.index');
    Route::GET('insert-patient', [PatientController::class, 'show'])->name('patient.show.insert');
    Route::POST('insert-patient', [PatientController::class, 'insert'])->name('patient.insert');
    Route::POST('update-patient-status', [PatientController::class, 'updateStatus']);
    Route::GET('import', [PatientController::class, 'showImport'])->name('patient.show.import');
    Route::POST('import', [PatientController::class, 'import'])->name('patient.import');
    ROute::GET('template', [PatientController::class, 'downloadTemplate'])->name('patient.template');
    Route::POST('search', [PatientController::class, 'ajaxSearch'])->name('patient.serach');

    //PATIENT PARAMETERS
    Route::GET('insert-parameters/{id?}', [PatientParametersController::class, 'show'])->name('parameter.show.insert');
    Route::POST('insert-parameters/{id?}', [PatientParametersController::class, 'insert'])->name('parameter.insert');
});

Route::GROUP(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
    Route::GET('login', [AdminController::class, 'show'])->name('auth.login.show');
    Route::POST('login', [AdminController::class, 'login'])->name('auth.login');
});

Route::FALLBACK(function() {
    return redirect()->route('auth.login.show');
});
