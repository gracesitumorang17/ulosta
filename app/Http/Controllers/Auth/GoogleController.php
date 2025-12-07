<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect user ke Google untuk autentikasi
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle callback dari Google setelah autentikasi
     */
    public function handleGoogleCallback()
    {
        try {
            // Dapatkan user dari Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            // Jika user tidak ada, buat user baru
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?? 'Google User',
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid('google_', true)),
                    'role' => 'buyer',
                    'phone' => null,
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken ?? null,
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Update google_id dan token jika user sudah ada tapi belum punya google_id
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken ?? null,
                        'provider' => 'google',
                        'provider_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
            }

            // Login user
            Auth::login($user, true); // true = remember me

            // Regenerate session untuk security
            request()->session()->regenerate();

            // Redirect ke homepage yang menampilkan welcomelogin
            return redirect()->intended('/homepage');

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Google Login Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Redirect dengan pesan error yang lebih detail
            return redirect()->route('masuk')->with('error', 'Gagal login dengan Google. Error: ' . $e->getMessage());
        }
    }
}
