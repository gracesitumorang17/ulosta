<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

// Root: if authenticated go to /homepage, else public welcome landing
Route::get('/', function () {
    return Auth::check() ? redirect()->route('homepage') : view('welcome');
})->name('welcome');

// show login form
Route::get('/masuk', function () {
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
        return redirect()->route('homepage');
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi salah.',
    ])->withInput();
})->name('masuk.submit');

// password reset request (placeholder)
Route::get('/lupa-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// show register form
Route::get('/daftar', function () {
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

    return redirect()->route('homepage')->with('success', 'Akun berhasil dibuat! Selamat datang di UlosTa.');
})->name('register.submit');

// Homepage (after login)
Route::get('/homepage', function () {
    // Use existing welcomelogin view as homepage
    return view('welcomelogin');
})->middleware('auth')->name('homepage');

// Add-to-cart route: guests are redirected to the login page; authenticated users go to the homepage (or cart)
Route::get('/tambah-ke-keranjang', function () {
    if (Auth::check()) {
        // When authenticated, send user to cart page
        return redirect()->route('keranjang');
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

// Set role after login (seller or buyer) and redirect accordingly — persist to user.role
Route::post('/set-role', [RoleController::class, 'setRole'])
    ->name('set.role')
    ->middleware('auth');

// Seller dashboard route (sudah memakai middleware EnsureUserIsSeller)
Route::get('/seller/dashboard', function () {
    return view('seller.dashboard');
})->name('seller.dashboard')->middleware(['auth', \App\Http\Middleware\EnsureUserIsSeller::class]);

// Public pages
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/daftar', [RegisterController::class, 'show'])->name('register');
Route::post('/daftar', [RegisterController::class, 'register'])->name('register.submit');

// simple login/logout routes (sesuaikan dengan auth scaffolding Anda)
Route::get('/masuk', fn() => view('masuk'))->name('masuk');
Route::post('/masuk', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('masuk.submit');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// role change (upgrade ke seller)
Route::post('/set-role', [RoleController::class, 'setRole'])->middleware('auth')->name('set.role');

// seller-only routes
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller/dashboard', fn() => view('seller.dashboard'))->name('seller.dashboard');
    // ... seller routes ...
});

// admin-only
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', fn() => view('admin.index'))->name('admin.home');
    // ... admin routes ...
});

// Example: routes accessible to seller OR admin
Route::middleware(['auth', 'role:admin,seller'])->group(function () {
    // ... shared routes ...
});

// Auth routes
Route::get('/masuk', function () {
    return view('masuk');
})->name('masuk');
Route::post('/masuk', [AuthController::class, 'login'])->name('masuk.submit');

Route::get('/register', function () {
    return view('daftar');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboards
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
    // ...existing seller routes...
});

Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/dashboard', function () {
        return view('buyer.dashboard');
    })->name('buyer.dashboard');
    // ...existing buyer routes...
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    // ...existing admin routes...
// Legacy home route alias -> redirect to homepage
Route::get('/home', function () {
    return redirect()->route('homepage');
})->middleware('auth')->name('home');

// Product detail (temporary demo route)
Route::get('/produk/{slug}', function ($slug) {
    $product = [
        'slug' => $slug,
        'title' => 'Ulos Ragihotang Premium',
        'price' => 1250000,
        'original_price' => 1500000,
        'reviews' => 28,
        'tags' => ['Ragi Hotang','Pernikahan'],
        'stock' => 15,
        'jenis' => 'Ragi Hotang',
        'fungsi' => 'Pernikahan',
        'ukuran' => '200 x 150 cm',
        'berat' => '800 gr',
        'material' => 'Katun Premium',
        'asal' => 'Sumatera Utara',
        'images' => [
            asset('image/Ulos Ragi Hotang.jpg'),
            asset('image/ulos1.jpeg'),
            asset('image/ulos2.jpg'),
            asset('image/ulos3.jpg'),
        ],
        'description' => 'Ulos Ragi Hotang Premium adalah kain tenun tradisional Batak dengan motif yang melambangkan keharmonisan dan kekuatan. Cocok untuk upacara pernikahan adat, ditenun dari benang premium dengan pewarnaan alami yang tahan lama.',
    ];

    $recommendations = [
        ['title'=>'Ulos Bintang Maratur','price'=>750000,'old'=>900000,'img'=>asset('image/Ulos Bintang Maratur.jpg'),'tag'=>'Kelahiran'],
        ['title'=>'Ulos Mangiring','price'=>860000,'old'=>990000,'img'=>asset('image/Ulos Mangiring.jpg'),'tag'=>'Pernikahan'],
        ['title'=>'Ulos Sibolang Rasta Pamontari','price'=>750000,'old'=>1000000,'img'=>asset('image/Ulos Sibolang Rasta Pamontari.jpg'),'tag'=>'Kelahiran'],
    ];

    return view('produk.detail', compact('product','recommendations'));
})->name('produk.detail');
// Cart routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::patch('/cart/{item}/qty', [CartController::class, 'updateQty'])->name('cart.qty');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.delete');
});
