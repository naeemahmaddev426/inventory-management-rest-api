<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return response()->json([
        'message' => 'Inventory Management REST API',
        'version' => 'v1',
        'status' => 'Running Successfully'
    ]);
});

Route::get('/reset-password', [ResetPasswordController::class, 'index'])
    ->name('password.reset');
