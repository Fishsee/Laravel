<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');

Route::get('/test-database-connection', 'App\Http\Controllers\DatabaseController@testConnection');

});
