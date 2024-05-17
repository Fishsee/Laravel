<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AquariumDataController;



Route::get('/', function () {
    return view('welcome');
});

// Routes for PH data
Route::get('/all-PH', [AquariumDataController::class, 'getAllPH']);
Route::get('/last-PH', [AquariumDataController::class, 'getLatestPH']);

// Routes for troebelheid data
Route::get('/all-troebelheid', [AquariumDataController::class, 'getAllTurbidity']);
Route::get('/last-troebelheid', [AquariumDataController::class, 'getLatestTurbidity']);



