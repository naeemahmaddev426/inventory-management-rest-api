<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return response()->json([
        'message' => 'Inventory Management REST API',
        'version' => 'v1',
        'status' => 'Running Successfully'
    ]);
});

Route::get('/reset-password', [ResetPasswordController::class, 'index'])
    ->name('password.reset');

// Design preview routes for styled auth pages
Route::view('/design-login', 'auth.login')->name('design.login');
Route::view('/design-register', 'auth.register')->name('design.register');
