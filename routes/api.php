<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AquariumDataController;
use Illuminate\Support\Facades\DB;


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

// Routes for pH data
Route::get('/all-PH/{aquarium_id}', [AquariumDataController::class, 'getAllPH']);
Route::get('/last-PH/{aquarium_id}', [AquariumDataController::class, 'getLatestPH']);
Route::get('/average-PH/{aquarium_id}/{date}', [AquariumDataController::class, 'getDailyAveragePH']);


// Routes for turbidity data
Route::get('/all-troebelheid/{aquarium_id}', [AquariumDataController::class, 'getAllTroebelheid']);
Route::get('/last-troebelheid/{aquarium_id}', [AquariumDataController::class, 'getLatestTroebelheid']);

// Routes for current data
Route::get('/all-stroming/{aquarium_id}', [AquariumDataController::class, 'getAllStroming']);
Route::get('/last-stroming/{aquarium_id}', [AquariumDataController::class, 'getLatestStroming']);

// Routes for water level data
Route::get('/all-waterlevel/{aquarium_id}', [AquariumDataController::class, 'getAllWaterLevel']);
Route::get('/last-waterlevel/{aquarium_id}', [AquariumDataController::class, 'getLatestWaterLevel']);




?>
