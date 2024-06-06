<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protected by Sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    // Routes accessible only to authenticated users
    // Put all Routes that require the access token here
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/userdata', [AuthController::class, 'userdata']);
    Route::post('/process-data/{id}', [DataController::class, 'processAndRetrieveData']);
    Route::post('/process-data', [DataController::class, 'processData']);
});