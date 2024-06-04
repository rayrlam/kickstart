<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedisController;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/redis/save', [RedisController::class, 'save']);
Route::get('/redis/get', [RedisController::class, 'get']);