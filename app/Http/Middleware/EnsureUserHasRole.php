<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:seller') or ->middleware('role:admin,seller')
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('masuk');
        }

        $user = Auth::user();
        $allowed = array_map('trim', explode(',', $roles));

        if (!isset($user->role) || !in_array($user->role, $allowed)) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
