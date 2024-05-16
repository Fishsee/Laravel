<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AquariumDataController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/all-PH', [AquariumDataController::class, 'getAllPH']);


