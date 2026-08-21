<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Web\WebDashboardController;

/*
|--------------------------------------------------------------------------
| Root — API info response
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return response()->json([
        'message'   => 'Inventory Management REST API',
        'version'   => 'v1',
        'status'    => 'Running Successfully',
        'dashboard' => url('/dashboard/login'),
    ]);
});

/*
|--------------------------------------------------------------------------
| Password Reset (Blade view)
|--------------------------------------------------------------------------
*/
Route::get('/reset-password', [ResetPasswordController::class, 'index'])
    ->name('password.reset');

/*
|--------------------------------------------------------------------------
| Dashboard Auth (public — no middleware)
|--------------------------------------------------------------------------
*/
Route::get( '/dashboard/login',    [WebDashboardController::class, 'showLogin']   )->name('dashboard.login');
Route::post('/dashboard/login',    [WebDashboardController::class, 'handleLogin'] )->name('dashboard.login.post');
Route::get( '/dashboard/register', [WebDashboardController::class, 'showRegister'])->name('dashboard.register');
Route::post('/dashboard/register', [WebDashboardController::class, 'handleRegister'])->name('dashboard.register.post');
Route::post('/dashboard/logout',   [WebDashboardController::class, 'logout']      )->name('dashboard.logout');
// Keep GET logout as fallback (link clicks)
Route::get( '/dashboard/logout',   [WebDashboardController::class, 'logout']      )->name('dashboard.logout.get');

/*
|--------------------------------------------------------------------------
| Dashboard Pages (protected — require session token)
|--------------------------------------------------------------------------
*/
Route::middleware('web.auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/home',       [WebDashboardController::class, 'index']     )->name('index');
    Route::get('/products',   [WebDashboardController::class, 'products']  )->name('products');
    Route::get('/categories', [WebDashboardController::class, 'categories'])->name('categories');
    Route::get('/brands',     [WebDashboardController::class, 'brands']    )->name('brands');
    Route::get('/units',      [WebDashboardController::class, 'units']     )->name('units');
    Route::get('/taxes',      [WebDashboardController::class, 'taxes']     )->name('taxes');
    Route::get('/warehouses', [WebDashboardController::class, 'warehouses'])->name('warehouses');
    Route::get('/suppliers',  [WebDashboardController::class, 'suppliers'] )->name('suppliers');
    Route::get('/customers',  [WebDashboardController::class, 'customers'] )->name('customers');
    Route::get('/purchases',  [WebDashboardController::class, 'purchases'] )->name('purchases');
});

/*
|--------------------------------------------------------------------------
| /dashboard redirect → login if not authed, dashboard if authed
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (session('auth_token')) {
        return redirect()->route('dashboard.index');
    }
    return redirect()->route('dashboard.login');
})->name('dashboard.home');
