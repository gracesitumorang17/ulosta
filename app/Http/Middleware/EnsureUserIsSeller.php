<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsSeller
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('masuk');
        }

        $user = Auth::user();
        if (!isset($user->role) || $user->role !== 'seller') {
            return redirect()->route('home')->with('error', 'Akses dashboard toko hanya untuk penjual.');
        }

        return $next($request);
    }
}
