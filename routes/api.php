<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('user-jwt')->group(function () {
        Route::get('/refresh-token', [AuthController::class, 'refresh']);
        Route::get('/user', [AuthController::class, 'getUser']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::resource('products', ProductController::class)->only(['index', 'show']);

Route::middleware('admin-jwt')->group(function () {
    Route::resource('products', ProductController::class)->only(['store', 'update', 'destroy']);
});
