<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\OrdersApiController;
use App\Http\Controllers\Api\SellerReportsApiController;

// Versi API v1
Route::prefix('v1')->group(function () {
    // Orders API (internal) - gunakan auth session dulu; bisa diganti ke Sanctum nanti
    Route::middleware(['auth'])->group(function () {
        Route::get('/orders', [OrdersApiController::class, 'index']);
        Route::get('/orders/{order_number}', [OrdersApiController::class, 'show']);
    });

    // Seller Reports API (internal) - wajib pakai sesi web + role seller
    Route::middleware(['web', 'auth:web', 'role:seller'])->group(function () {
        Route::get('/seller/reports/summary', [SellerReportsApiController::class, 'summary']);
        Route::get('/seller/reports/recent-orders', [SellerReportsApiController::class, 'recentOrders']);
        // Endpoint diagnostik opsional jika tersedia di controller
        Route::get('/seller/reports/debug-delivered', [SellerReportsApiController::class, 'debugDelivered']);
    });
});
