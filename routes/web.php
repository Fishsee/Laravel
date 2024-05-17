<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AquariumDataController;



Route::get('/', function () {
    return view('welcome');
});

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


