<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Homepage route - redirect authenticated users to /home, guests see welcome
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome');
})->name('homepage');

// show login form (redirect authenticated users to /home)
Route::get('/masuk', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('masuk');
})->name('masuk');

// handle login submission
Route::post('/masuk', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        // redirect to authenticated homepage
        return redirect()->route('home');
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi salah.',
    ])->withInput();
})->name('masuk.submit');

// password reset request (placeholder)
Route::get('/lupa-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// show register form (redirect authenticated users to /home)
Route::get('/daftar', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('daftar');
})->name('register');

// handle register submission
Route::post('/daftar', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
        'password' => 'required|string|min:8|confirmed',
        'terms' => 'required|accepted',
    ], [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',
        'phone.required' => 'Nomor telepon wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'terms.required' => 'Anda harus menyetujui syarat & ketentuan.',
    ]);

    // Create user
    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    // Auto login after registration
    Auth::login($user);
    $request->session()->regenerate();

    // redirect to authenticated homepage after successful registration
    return redirect()->route('home')->with('success', 'Akun berhasil dibuat! Selamat datang di UlosTa.');
})->name('register.submit');

// Homepage for authenticated users
Route::get('/home', function () {
    return view('welcomelogin');
})->middleware('auth')->name('home');

// Add-to-cart route: guests are redirected to the login page; authenticated users go to the homepage (or cart)
Route::get('/tambah-ke-keranjang', function () {
    if (Auth::check()) {
        // TODO: change to actual cart route when implemented
        return redirect()->route('homepage');
    }
    return redirect()->route('masuk');
})->name('tambah.ke.keranjang');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Admin routes - dapat diakses tanpa login
Route::group(['prefix' => 'admin'], function () {
    // Admin dashboard
    Route::get('/dashboard', function () {
        return view('admin.admindashboard');
    })->name('admin.dashboard');

    // Admin verifikasi penjual
    Route::get('/verifikasi-penjual', function () {
        return view('admin.verifikasi-penjual');
    })->name('admin.verifikasi-penjual');

    // Admin semua penjual
    Route::get('/semua-penjual', function () {
        return view('admin.semua-penjual');
    })->name('admin.semua-penjual');

    // Admin penjual tidak aktif
    Route::get('/penjual-tidak-aktif', function () {
        return view('admin.penjual-tidak-aktif');
    })->name('admin.penjual-tidak-aktif');

    // Admin laporan
    Route::get('/laporan', function () {
        return view('admin.laporan');
    })->name('admin.laporan');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.admindashboard');
    })->name('dashboard');
    
    Route::get('/dashboard', function () {
        return view('admin.admindashboard');
    })->name('dashboard');
    
    Route::get('/verifikasi-penjual', function () {
        return view('admin.verifikasi-penjual');
    })->name('verifikasi-penjual');
    
    Route::get('/semua-penjual', function () {
        return view('admin.semua-penjual');
    })->name('semua-penjual');
    
    Route::get('/penjual-tidak-aktif', function () {
        return view('admin.penjual-tidak-aktif');
    })->name('penjual-tidak-aktif');
    
    Route::get('/laporan', function () {
        return view('admin.laporan');
    })->name('laporan');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.admindashboard');
    })->name('dashboard');
    
    Route::get('/verifikasi-penjual', function () {
        return view('admin.verifikasi-penjual');
    })->name('verifikasi-penjual');
    
    Route::get('/semua-penjual', function () {
        return view('admin.semua-penjual');
    })->name('semua-penjual');
    
    Route::get('/penjual-tidak-aktif', function () {
        return view('admin.penjual-tidak-aktif');
    })->name('penjual-tidak-aktif');
    
    Route::get('/laporan', function () {
        return view('admin.laporan');
    })->name('laporan');
});
