<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Usage in routes: ->middleware('role:admin|seller')
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('masuk');
        }

        $allowed = explode('|', $roles);
        $userRole = Auth::user()->role ?? 'buyer';

        if (!in_array($userRole, $allowed)) {
            abort(403);
        }

        return $next($request);
    }
}
