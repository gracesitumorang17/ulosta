<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;

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
Route::get('/homepage', [HomeController::class, 'index'])->middleware('auth')->name('homepage');

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
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Wishlist routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.delete');
    Route::get('/wishlist/count', [WishlistController::class, 'getCount'])->name('wishlist.count');
});

// Checkout routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Profile routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    Route::put('/profil/update', [ProfileController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [ProfileController::class, 'updatePassword'])->name('profil.password');
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
