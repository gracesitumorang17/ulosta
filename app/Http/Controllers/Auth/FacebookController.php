<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Str;

class FacebookController extends Controller
{
    /**
     * Redirect to Facebook for authentication
     */
    public function redirect()
    {
        try {
            \Log::info('Facebook Redirect Started');
            \Log::info('Config:', [
                'client_id' => config('services.facebook.client_id'),
                'redirect' => config('services.facebook.redirect'),
            ]);
            
            return Socialite::driver('facebook')
                ->scopes(['email', 'public_profile'])
                ->redirect();
        } catch (Exception $e) {
            \Log::error('Facebook Redirect Error: ' . $e->getMessage());
            return redirect()->route('masuk')->with('error', 'Gagal menghubungkan ke Facebook: ' . $e->getMessage());
        }
    }

    /**
     * Handle Facebook callback
     */
    public function callback()
    {
        // Debug: Write to file to confirm callback is reached
        file_put_contents(storage_path('logs/facebook-debug.txt'), 
            date('Y-m-d H:i:s') . " - Callback reached\n" . 
            "Request URL: " . request()->fullUrl() . "\n" .
            "Request params: " . json_encode(request()->all()) . "\n\n", 
            FILE_APPEND
        );
        
        try {
            \Log::info('Facebook Callback Started');
            \Log::info('Request params:', request()->all());
            
            // Check if user denied permission
            if (request()->has('error')) {
                \Log::warning('User denied Facebook permission');
                return redirect()->route('masuk')->with('error', 'Anda membatalkan login dengan Facebook.');
            }
            
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
            
            \Log::info('Facebook User Data:', [
                'id' => $facebookUser->id,
                'name' => $facebookUser->name,
                'email' => $facebookUser->email ?? 'no email',
            ]);
            
            // Check if user already exists with this Facebook ID
            $user = User::where('facebook_id', $facebookUser->id)->first();

            if ($user) {
                \Log::info('User found with Facebook ID: ' . $user->id);
                // Update user info if exists
                $user->update([
                    'name' => $facebookUser->name,
                    'avatar' => $facebookUser->avatar,
                ]);
            } else {
                // Generate email if not provided by Facebook
                $email = $facebookUser->email ?? $facebookUser->id . '@facebook.user';
                
                \Log::info('Checking email: ' . $email);
                
                // Check if user exists with this email
                $user = User::where('email', $email)->first();

                if ($user) {
                    \Log::info('User found with email, linking Facebook ID');
                    // Link Facebook account to existing user
                    $user->update([
                        'facebook_id' => $facebookUser->id,
                        'avatar' => $facebookUser->avatar,
                    ]);
                } else {
                    \Log::info('Creating new user');
                    // Create new user
                    $user = User::create([
                        'name' => $facebookUser->name,
                        'email' => $email,
                        'facebook_id' => $facebookUser->id,
                        'avatar' => $facebookUser->avatar,
                        'password' => Hash::make(Str::random(24)), // Random password
                        'email_verified_at' => now(), // Auto verify email from Facebook
                        'role' => 'buyer', // Default role
                    ]);
                    \Log::info('New user created: ' . $user->id);
                }
            }

            // Login user
            Auth::login($user);
            
            \Log::info('User logged in successfully: ' . $user->id);

            return redirect('/')->with('success', 'Login dengan Facebook berhasil!');

        } catch (Exception $e) {
            \Log::error('Facebook Login Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('masuk')->with('error', 'Gagal login dengan Facebook. Silakan coba lagi.');
        }
    }

    /**
     * API: Redirect to Facebook for authentication (return redirect URL)
     */
    public function apiRedirect()
    {
        $redirectUrl = Socialite::driver('facebook')
            ->scopes(['public_profile'])
            ->stateless()
            ->redirect()
            ->getTargetUrl();
        
        return response()->json([
            'success' => true,
            'redirect_url' => $redirectUrl
        ]);
    }

    /**
     * API: Handle Facebook callback and return token
     */
    public function apiCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
            
            // Check if user already exists with this Facebook ID
            $user = User::where('facebook_id', $facebookUser->id)->first();

            if ($user) {
                // Update user info if exists
                $user->update([
                    'name' => $facebookUser->name,
                    'avatar' => $facebookUser->avatar,
                ]);
            } else {
                // Generate email if not provided by Facebook
                $email = $facebookUser->email ?? $facebookUser->id . '@facebook.user';
                
                // Check if user exists with this email
                $user = User::where('email', $email)->first();

                if ($user) {
                    // Link Facebook account to existing user
                    $user->update([
                        'facebook_id' => $facebookUser->id,
                        'avatar' => $facebookUser->avatar,
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $facebookUser->name,
                        'email' => $email,
                        'facebook_id' => $facebookUser->id,
                        'avatar' => $facebookUser->avatar,
                        'password' => Hash::make(Str::random(24)),
                        'email_verified_at' => now(),
                        'role' => 'buyer',
                    ]);
                }
            }

            // Generate token for API (if using Sanctum)
            $token = $user->createToken('facebook-login')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login dengan Facebook berhasil',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'avatar' => $user->avatar,
                ],
                'token' => $token
            ]);

        } catch (Exception $e) {
            \Log::error('Facebook API Login Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal login dengan Facebook',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
