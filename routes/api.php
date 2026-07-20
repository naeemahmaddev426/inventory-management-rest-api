<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\Auth\EmailVerificationController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\UnitController;
use App\Http\Controllers\Api\V1\TaxController;

Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::apiResource('categories', CategoryController::class);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password',[AuthController::class, 'resetPassword']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('units', UnitController::class);
    Route::apiResource('taxes', TaxController::class);
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::put('/change-password',[AuthController::class,'changePassword']);
        Route::post('/email/verification-notification',[EmailVerificationController::class, 'send']);
        Route::post('/email/resend',[EmailVerificationController::class, 'resend']);
        
    });
    Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
});