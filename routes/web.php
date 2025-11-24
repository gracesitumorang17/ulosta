<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Models\Product;
use App\Http\Controllers\ProfileController;

// Root: if authenticated go to /homepage, else public welcome landing
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('homepage');
    }

    // Fetch a few active, in-stock products for the public landing page
    $products = Product::active()->inStock()->latest()->take(9)->get()->map(function ($p) {
        return [
            'id' => $p->id,
            'name' => $p->name,
            'description' => $p->description,
            'image' => $p->image,
            'tag' => $p->tag,
            'formatted_price' => $p->formatted_price,
            'formatted_original_price' => $p->formatted_original_price,
        ];
    });

    return view('welcome', compact('products'));
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

// Product detail route
Route::get('/produk/{id}', function ($id) {
    $product = Product::findOrFail($id);
    
    // Convert to array format expected by the view
    $productData = [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->formatted_price,
        'original_price' => $product->formatted_original_price,
        'image' => $product->image,
        'tag' => $product->tag,
        'stock' => $product->stock,
        'category' => $product->tag,
        'function' => $product->tag,
        'type' => $product->tag,
        'size' => '200 x 150 cm',
        'weight' => '800 gram',
        'material' => 'Katun Premium', 
        'origin' => 'Sumatera Utara',
        'reviews' => '64 reviews'
    ];

    return view('detail-produk', ['product' => $productData]);
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
