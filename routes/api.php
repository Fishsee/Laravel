<?php

use App\Http\Controllers\ConditionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AquariumDataController;
use App\Http\Controllers\DataController;

// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/data-recieve', [DataController::class, 'getData']);
Route::post('/data-send', [DataController::class, 'postData']);

//Route::post('/data-send', [AquariumDataController::class, 'postData']);
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
    Route::get('/all-troebelheid/{aquarium_id}', [AquariumDataController::class, 'getAllturbidity'])->name('all-troebelheid');
    Route::get('/last-troebelheid/{aquarium_id}', [AquariumDataController::class, 'getLatestturbidity'])->name('last-troebelheid');
    Route::get('/average-troebelheid/{aquarium_id}/{date}', [AquariumDataController::class, 'getDailyAverageturbidity'])->name('average-troebelheid');

    // Routes for current data
    Route::get('/all-stroming/{aquarium_id}', [AquariumDataController::class, 'getAllflow_rate'])->name('all-stroming');
    Route::get('/last-stroming/{aquarium_id}', [AquariumDataController::class, 'getLatestflow_rate'])->name('last-stroming');
    Route::get('/average-stroming/{aquarium_id}/{date}', [AquariumDataController::class, 'getDailyAverageflow_rate'])->name('average-stroming');

    // Routes for water level data
    Route::get('/all-waterlevel/{aquarium_id}', [AquariumDataController::class, 'getAllwater_level'])->name('all-waterlevel');
    Route::get('/last-waterlevel/{aquarium_id}', [AquariumDataController::class, 'getLatestwater_level'])->name('last-waterlevel');
    Route::get('/average-waterlevel/{aquarium_id}/{date}', [AquariumDataController::class, 'getDailyAveragewater_level'])->name('average-waterlevel');

    // Routes for temperature data
    Route::get('/all-temperature/{aquarium_id}', [AquariumDataController::class, 'getAllTemperatures'])->name('all-temperature');
    Route::get('/last-temperature/{aquarium_id}', [AquariumDataController::class, 'getLatestTemperature'])->name('last-temperature');
    Route::get('/average-temperature/{aquarium_id}/{date?}', [AquariumDataController::class, 'getDailyAverageTemperature'])->name('average-temperature');

// Routes for distance data
    Route::get('/all-distance/{aquarium_id}', [AquariumDataController::class, 'getAllDistances'])->name('all-distance');
    Route::get('/last-distance/{aquarium_id}', [AquariumDataController::class, 'getLatestDistance'])->name('last-distance');
    Route::get('/average-distance/{aquarium_id}/{date?}', [AquariumDataController::class, 'getDailyAverageDistance'])->name('average-distance');

// Routes for light level data
    Route::get('/all-light-level/{aquarium_id}', [AquariumDataController::class, 'getAllLightLevels'])->name('all-light-level');
    Route::get('/last-light-level/{aquarium_id}', [AquariumDataController::class, 'getLatestLightLevel'])->name('last-light-level');
    Route::get('/average-light-level/{aquarium_id}/{date?}', [AquariumDataController::class, 'getDailyAverageLightLevel'])->name('average-light-level');

    //Route for checking and adjusting conditions fish
    Route::get('/aquarium/{aquariumId}/check-conditions', [ConditionsController::class, 'checkConditions']);
    Route::get('/aquarium/{aquariumId}/drop-ph-tablet', [ConditionsController::class, 'dropPHTablet']);
});

?>
