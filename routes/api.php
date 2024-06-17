<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedisController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/increment-visitor-count', [RedisController::class, 'incrementVisitorCount']);
Route::get('/get-visitor-count', [RedisController::class, 'getVisitorCount']);