<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSeller
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user || !$user->is_seller) {
            // Jika bukan penjual, arahkan ke homepage biasa.
            return redirect()->route('homepage')->with('error', 'Akses khusus penjual.');
        }
        return $next($request);
    }
}
