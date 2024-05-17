<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AquariumDataController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Routes protected by Sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    // Routes accessible only to authenticated users
    // Put all Routes that  require the access token here
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/userdata', [AuthController::class, 'userdata']);
});
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);

// Routes for PH data
Route::get('/all-PH', [AquariumDataController::class, 'getAllPH']);
Route::get('/last-PH', [AquariumDataController::class, 'getLatestPH']);

// Routes for turbidity data
Route::get('/all-troebelheid', [AquariumDataController::class, 'getAllTroebelheid']);
Route::get('/last-troebelheid', [AquariumDataController::class, 'getLatestTroebelheid']);

// Routes for current data
Route::get('/all-stroming', [AquariumDataController::class, 'getAllStroming']);
Route::get('/last-stroming', [AquariumDataController::class, 'getLatestStroming']);

// Routes for water level data
Route::get('/all-waterlevel', [AquariumDataController::class, 'getAllWaterLevel']);
Route::get('/last-waterlevel', [AquariumDataController::class, 'getLatestWaterLevel']);


?>
