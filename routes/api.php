<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AquariumDataController;

// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Routes protected by Sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    // Routes accessible only to authenticated users
    Route::get('/user', [AuthController::class, 'user'])->name('user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');

    // Routes for pH data
    Route::get('/all-PH/{aquarium_id}', [AquariumDataController::class, 'getAllPH'])->name('all-PH');
    Route::get('/last-PH/{aquarium_id}', [AquariumDataController::class, 'getLatestPH'])->name('last-PH');
    Route::get('/average-PH/{aquarium_id}/{date}', [AquariumDataController::class, 'getDailyAveragePH'])->name('average-PH');

    // Routes for turbidity data
    Route::get('/all-troebelheid/{aquarium_id}', [AquariumDataController::class, 'getAllTroebelheid'])->name('all-troebelheid');
    Route::get('/last-troebelheid/{aquarium_id}', [AquariumDataController::class, 'getLatestTroebelheid'])->name('last-troebelheid');
    Route::get('/average-troebelheid/{aquarium_id}/{date}', [AquariumDataController::class, 'getDailyAverageTroebelheid'])->name('average-troebelheid');

    // Routes for current data
    Route::get('/all-stroming/{aquarium_id}', [AquariumDataController::class, 'getAllStroming'])->name('all-stroming');
    Route::get('/last-stroming/{aquarium_id}', [AquariumDataController::class, 'getLatestStroming'])->name('last-stroming');
    Route::get('/average-stroming/{aquarium_id}/{date}', [AquariumDataController::class, 'getDailyAverageStroming'])->name('average-stroming');

    // Routes for water level data
    Route::get('/all-waterlevel/{aquarium_id}', [AquariumDataController::class, 'getAllWaterLevel'])->name('all-waterlevel');
    Route::get('/last-waterlevel/{aquarium_id}', [AquariumDataController::class, 'getLatestWaterLevel'])->name('last-waterlevel');
    Route::get('/average-waterlevel/{aquarium_id}/{date}', [AquariumDataController::class, 'getDailyAverageWaterLevel'])->name('average-waterlevel');
});

?>
