<?php

use App\Http\Controllers\ExpoApp\CoachController;
use App\Http\Controllers\ExpoApp\PatientController;
use App\Http\Controllers\ExpoApp\PatientParametersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::GROUP(['middleware' => ["auth:sanctum"]], function() {
    // HEALTH COACHES
    Route::GET('healthCoaches', [CoachController::class, 'getHealthCoaches']);

    //PATIENTS
    Route::GET('/user', [PatientController:: class, 'getPatient']);
    Route::GET('logout', [PatientController::class, 'logout']);

    //PATIENTS PARAMETERS
    Route::GET('healthParameters', [PatientParametersController::class, 'gethealthParameters']);
    
    Route::POST('insertRbsResult', [PatientParametersController::class, 'inserRbsResult']);
    Route::GET('getRbsData', [PatientParametersController::class, 'getRbsData']);
    Route::GET('getRbsDetailsFromAPI', [PatientParametersController::class , 'getRbsDetailsFromAPI']);

    Route::POST('insertWeightResult', [PatientParametersController::class, 'insertWeightResult']);
    Route::GET('getWeightData', [PatientParametersController::class, 'getWeightData']);
    Route::GET('getWeightDetailsFromAPI', [PatientParametersController::class , 'getWeightDetailsFromAPI']);

    Route::POST('insertBpResult', [PatientParametersController::class, 'insertBpResult']);
    Route::GET('getBpData', [PatientParametersController::class, 'getBpData']);
    Route::GET('getBpDetailsFromAPI', [PatientParametersController::class , 'getBpDetailsFromAPI']);
});

Route::POST('login', [PatientController::class, 'login']);
Route::POST('forget-password', [PatientController::class, 'forgetPassword']);
