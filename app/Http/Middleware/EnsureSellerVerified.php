<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSellerVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->role === 'seller') {
            // Hanya penjual yang telah disetujui (verification_status=approved) yang boleh akses dashboard penjual
            if ($user->verification_status !== 'approved') {
                // Jika pending atau rejected, arahkan ke halaman status verifikasi
                return redirect()->route('seller.verification.pending')
                    ->with('error', 'Akses dashboard penjual dibatasi hingga verifikasi disetujui.');
            }
        }
        return $next($request);
    }
}
