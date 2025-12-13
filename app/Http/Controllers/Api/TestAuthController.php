<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TestAuthController extends Controller
{
    use ApiResponse;

    /**
     * TEST ONLY: Login dengan Google (simulasi untuk testing)
     * Endpoint ini untuk testing tanpa perlu Google OAuth access token
     * JANGAN GUNAKAN DI PRODUCTION!
     */
    public function loginGoogleTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Simulasi data dari Google
        $googleUser = (object)[
            'id' => 'google_' . md5($request->email),
            'email' => $request->email,
            'name' => $request->name,
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($request->name),
        ];

        // Check if user exists
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            // Create new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'provider' => 'google',
                'provider_id' => $googleUser->id,
                'role' => 'buyer',
                'password' => Hash::make(uniqid()),
            ]);
        } else {
            // Update existing user
            $user->update([
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ], 'Login with Google successful (TEST MODE)');
    }

    /**
     * TEST ONLY: Login dengan Facebook (simulasi untuk testing)
     */
    public function loginFacebookTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Simulasi data dari Facebook
        $facebookUser = (object)[
            'id' => 'facebook_' . md5($request->email),
            'email' => $request->email,
            'name' => $request->name,
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($request->name),
        ];

        // Check if user exists
        $user = User::where('email', $facebookUser->email)->first();

        if (!$user) {
            // Create new user
            $user = User::create([
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'facebook_id' => $facebookUser->id,
                'avatar' => $facebookUser->avatar,
                'provider' => 'facebook',
                'provider_id' => $facebookUser->id,
                'role' => 'buyer',
                'password' => Hash::make(uniqid()),
            ]);
        } else {
            // Update existing user
            $user->update([
                'facebook_id' => $facebookUser->id,
                'avatar' => $facebookUser->avatar,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ], 'Login with Facebook successful (TEST MODE)');
    }
}
