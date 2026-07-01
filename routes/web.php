<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Inventory Management REST API',
        'version' => 'v1',
        'status' => 'Running Successfully'
    ]);
});
