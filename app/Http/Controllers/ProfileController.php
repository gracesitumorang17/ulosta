<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user profile page.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $wishlistCount = $user->wishlists()->count();
        $cartCount = $user->cartItems()->count();
        
        // Get orders with filters
        $statusFilter = $request->get('status', 'all');
        $search = $request->get('search');
        
        $ordersQuery = $user->orders()->with('orderItems');
        
        // Apply status filter
        if ($statusFilter && $statusFilter !== 'all') {
            $ordersQuery->where('status', $statusFilter);
        }
        
        // Apply search
        if ($search) {
            $ordersQuery->where(function($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhereHas('orderItems', function($q2) use ($search) {
                      $q2->where('product_name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        $orders = $ordersQuery->orderBy('created_at', 'desc')->get();
        
        // Get status counts
        $statusCounts = [
            'all' => $user->orders()->count(),
            'pending' => $user->orders()->where('status', 'pending')->count(),
            'processing' => $user->orders()->where('status', 'processing')->count(),
            'shipped' => $user->orders()->where('status', 'shipped')->count(),
            'delivered' => $user->orders()->where('status', 'delivered')->count(),
            'cancelled' => $user->orders()->where('status', 'cancelled')->count(),
        ];
        
        return view('profil', compact('user', 'wishlistCount', 'cartCount', 'orders', 'statusCounts'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'phone.required' => 'Nomor telepon wajib diisi.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        
        if (isset($validated['address'])) {
            $user->address = $validated['address'];
        }

        $user->save();

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profil')->with('success', 'Password berhasil diperbarui!');
    }
}
