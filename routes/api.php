<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

 Route::get('/user', function (Request $request) {
     return $request->user();
 })->middleware('auth:sanctum');

Route::prefix('auth')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->prefix('auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/search',          [UserController::class, 'search']);
    Route::get('/users/{username}',      [UserController::class, 'show']);
    Route::put('/users/me',              [UserController::class, 'update']);
    Route::post('/users/me/avatar',      [UserController::class, 'updateAvatar']);
});