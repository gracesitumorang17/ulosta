<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// Test Facebook Configuration
Route::get('/test-facebook-config', function () {
    $config = config('services.facebook');
    
    return response()->json([
        'client_id' => $config['client_id'],
        'client_secret' => substr($config['client_secret'], 0, 10) . '...',
        'redirect' => $config['redirect'],
        'socialite_installed' => class_exists('Laravel\Socialite\Facades\Socialite'),
    ]);
});

// Test Facebook Redirect URL
Route::get('/test-facebook-redirect', function () {
    try {
        $driver = Socialite::driver('facebook');
        $redirect = $driver->scopes(['public_profile'])->redirect();
        $url = $redirect->getTargetUrl();
        
        return response()->json([
            'success' => true,
            'redirect_url' => $url,
            'message' => 'Facebook redirect URL generated successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Test if callback route is accessible
Route::get('/test-callback-access', function () {
    return response()->json([
        'message' => 'Callback route is accessible',
        'request_all' => request()->all(),
        'request_url' => request()->fullUrl(),
    ]);
});
