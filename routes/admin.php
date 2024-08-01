<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChatRoomController;
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
    Route::GET('view-coach/{id?}', [CoachController::class, 'view'])->name('coach.view');

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
    Route::GET('update-parameters/{id?}', [PatientParametersController::class, 'update'])->name('parameter.show.update');
    Route::POST('update-parameters/{id?}', [PatientParametersController::class, 'edit'])->name('parameter.update');
    Route::POST('/update-weight', [PatientParametersController::class, 'updateWeight']);
    Route::POST('/update-rbs', [PatientParametersController::class, 'updateRbs']);
    Route::POST('/update-bp', [PatientParametersController::class, 'updateBp']);
    Route::GET('view-parameters/{id?}', [PatientParametersController::class, 'view'])->name('parameter.view');
    Route::GET('transfer/{id?}', [PatientParametersController::class, 'showTransfer'])->name('parameter.show.transfer');
    Route::POST('transfer/{id?}', [PatientParametersController::class, 'transfer'])->name('parameter.transfer');
    Route::POST('/get-complex', [PatientParametersController::class, 'getComplexName']);
    Route::GET('view-notification', [PatientParametersController::class, 'viewNotification'])->name('parameter.view.notification');
    Route::GET('read-notification/{id?}/{notifyId?}', [PatientParametersController::class, 'readNotification'])->name('parameter.read.notification');
    Route::GET('reject/{id?}/{notifyId?}', [PatientParametersController::class, 'reject'])->name('parameter.reject');
    Route::GET('accept/{id?}/{notifyId?}', [PatientParametersController::class, 'accept'])->name('parameter.accept');
    Route::GET('read/{id?}/{notifyId?}', [PatientParametersController::class, 'read'])->name('parameter.read');

    //CHAT ROOMS
    Route::GET('chat-rooms', [ChatRoomController::class, 'index'])->name('chat-room.index');
    Route::GET('insert-chat-room', [ChatRoomController::class, 'show'])->name('chat-room.show.insert');
    Route::POST('insert-chat-room', [ChatRoomController::class, 'insert'])->name('chat-room.insert');
    Route::POST('update-room-status', [ChatRoomController::class, 'updateStatus']);
});

Route::GROUP(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
    Route::GET('login', [AdminController::class, 'show'])->name('auth.login.show');
    Route::POST('login', [AdminController::class, 'login'])->name('auth.login');
});

Route::FALLBACK(function() {
    return redirect()->route('auth.login.show');
});
