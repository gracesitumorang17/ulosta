<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RoleController extends Controller
{
    public function setRole(Request $request)
    {
        $request->validate(['role' => 'required|string|in:seller,buyer']);

        $authId = Auth::id();
        if (!$authId) {
            return redirect()->route('masuk');
        }

        // Ambil instance Eloquent User agar method save() tersedia
        $user = User::find($authId);
        if (!$user) {
            return redirect()->route('masuk')->with('error', 'User tidak ditemukan.');
        }

        // jika butuh approval, ganti logika ini untuk membuat status pending
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Peran Anda telah diperbarui.');
    }
}
