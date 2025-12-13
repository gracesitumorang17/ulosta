<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\OrdersApiController;

// Versi API v1
Route::prefix('v1')->group(function () {
    // Orders API (internal) - gunakan auth session dulu; bisa diganti ke Sanctum nanti
    Route::middleware(['auth'])->group(function () {
        Route::get('/orders', [OrdersApiController::class, 'index']);
        Route::get('/orders/{order_number}', [OrdersApiController::class, 'show']);
    });
});
