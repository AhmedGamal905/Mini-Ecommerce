<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('user-jwt')->group(function () {
        Route::get('/refresh-token', [AuthController::class, 'refresh']);
        Route::get('/user', [AuthController::class, 'getUser']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// Public Products
Route::resource('products', ProductController::class)->only(['index', 'show']);

// Admin Product
Route::middleware('admin-jwt')->group(function () {
    Route::resource('products', ProductController::class)->only(['store', 'update', 'destroy']);

    // Product images routes
    Route::prefix('products')
        ->controller(ProductImageController::class)
        ->group(function () {
            Route::post('/{product}/images/', 'store')->name('store');
            Route::delete('/{product}/images/{media}', 'destroy')->name('destroy');
        });
});

// User Comments
Route::middleware('user-jwt')->group(function () {
    Route::resource('products.comments', CommentController::class)->only(['store', 'update', 'destroy']);
});
