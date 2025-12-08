<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Models\Product;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;

// Test routes for Facebook
require __DIR__.'/test-facebook.php';

// Root: redirect based on authentication and role
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role ?? 'buyer';
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($role === 'seller') {
            return redirect()->route('seller.dashboard');
        }
        // For buyers, go to homepage
        return redirect()->route('homepage');
    }

    // For guests, show welcome page
    $products = Product::active()->inStock()->latest()->take(9)->get()->map(function ($p) {
        return [
            'id' => $p->id,
            'name' => $p->name,
            'description' => $p->description,
            'image' => $p->image,
            'tag' => $p->tag,
            'category' => $p->category,
            'price' => $p->formatted_price,
            'desc' => $p->description,
        ];
    });

    return view('welcome', compact('products'));
})->name('welcome');

// Product detail route (NO AUTHENTICATION REQUIRED - PUBLIC ACCESS)
Route::get('/produk/{id}', function ($id) {
    \Log::info('🔵 PRODUCT ROUTE HIT - ID: ' . $id . ' | User: ' . (Auth::check() ? Auth::user()->email : 'GUEST'));
    
    try {
        $product = Product::findOrFail($id);
        
        // Get recommendations (other products, excluding current)
        $recommendations = Product::where('id', '!=', $id)
            ->active()
            ->inStock()
            ->latest()
            ->take(3)
            ->get();
        
        // Check if product is in user's wishlist
        $isInWishlist = false;
        $recommendationWishlist = [];
        if (Auth::check()) {
            $isInWishlist = \App\Models\Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
            
            // Check wishlist status for recommendations
            $wishlistProductIds = \App\Models\Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
            foreach ($recommendations as $rec) {
                $recommendationWishlist[$rec->id] = in_array($rec->id, $wishlistProductIds);
            }
        }
        
        // Convert to array format expected by the view
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->formatted_price,
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
            'reviews' => '64 reviews',
            'is_in_wishlist' => $isInWishlist
        ];

        \Log::info('✅ PRODUCT LOADED: ' . $product->name);
        return view('detail-produk', [
            'product' => $productData, 
            'recommendations' => $recommendations,
            'recommendationWishlist' => $recommendationWishlist
        ]);
    } catch (\Exception $e) {
        \Log::error('❌ PRODUCT ERROR - ID: ' . $id . ' | ' . $e->getMessage());
        return redirect()->route('welcome')->with('error', 'Produk tidak ditemukan');
    }
})->name('produk.detail');

// show login form
Route::get('/masuk', function () {
    return view('masuk');
})->name('masuk');

// logout route - moved to line 150 to avoid duplication

// handle login submission
Route::post('/masuk', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Check if user exists
    $user = \App\Models\User::where('email', $credentials['email'])->first();
    
    if (!$user) {
        return back()->withErrors([
            'email' => 'Email tidak terdaftar.',
        ])->withInput();
    }

    // Verify password
    if (!\Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors([
            'email' => 'Password salah.',
        ])->withInput();
    }

    // Login the user
    Auth::login($user);
    $request->session()->regenerate();
    
    $role = Auth::user()->role;
    // Redirect by role
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($role === 'seller') {
        return redirect()->route('seller.dashboard');
    }
    return redirect()->route('homepage');
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

    // Determine role from checkbox
    $role = $request->boolean('seller') ? 'seller' : 'buyer';

    // Create user with phone and role
    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'phone' => $validated['phone'],
        'role' => $role,
    ]);

    // Auto login after registration
    Auth::login($user);
    $request->session()->regenerate();

    // If seller, send to onboarding flow; else homepage
    if ($role === 'seller') {
        return redirect()->route('seller.onboarding.info')
            ->with('success', 'Akun dibuat sebagai penjual. Lengkapi informasi toko Anda.');
    }

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

// Cart routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::patch('/cart/{item}/qty', [CartController::class, 'updateQty'])->name('cart.qty');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.delete');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
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
    Route::get('/detail-pembayaran/{orderId}', [CheckoutController::class, 'detailPembayaran'])->name('detail.pembayaran');
    Route::get('/instruksi-pembayaran/{orderId}', [CheckoutController::class, 'instruksiPembayaran'])->name('instruksi.pembayaran');
});

// Profile routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    Route::put('/profil/update', [ProfileController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [ProfileController::class, 'updatePassword'])->name('profil.password');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.admindashboard');
    })->name('dashboard');

    Route::get('/dashboard', function () {
        // Get verification statistics
        $pendingVerifications = \App\Models\User::where('role', 'seller')
            ->where('verification_status', 'pending')
            ->get();
        
        $approvedVerifications = \App\Models\User::where('role', 'seller')
            ->where('verification_status', 'approved')
            ->get();
        
        $rejectedVerifications = \App\Models\User::where('role', 'seller')
            ->where('verification_status', 'rejected')
            ->get();
            
        $totalSellers = \App\Models\User::where('role', 'seller')->count();
        
        $recentVerifications = \App\Models\User::where('role', 'seller')
            ->whereNotNull('verification_status')
            ->orderBy('verification_submitted_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.admindashboard', compact(
            'pendingVerifications', 
            'approvedVerifications', 
            'rejectedVerifications',
            'totalSellers',
            'recentVerifications'
        ));
    })->name('dashboard');

    Route::get('/verifikasi-penjual', function () {
        return view('admin.verifikasi-penjual');
    })->name('verifikasi-penjual');

    // TODO: Implement these admin features later
    // Route::get('/semua-penjual', function () {
    //     return view('admin.semua-penjual');
    // })->name('semua-penjual');

    // Route::get('/penjual-tidak-aktif', function () {
    //     return view('admin.penjual-tidak-aktif');
    // })->name('penjual-tidak-aktif');

    // Route::get('/laporan', function () {
    //     return view('admin.laporan');
    // })->name('laporan');
});

// (removed duplicate admin route group)

// ========== Seller area (basic auth-protected routes) ==========
// Seller onboarding: step 1 - store basic information
Route::middleware('auth')->group(function () {
    Route::get('/seller/onboarding/info', function () {
        $defaults = [
            'name' => Auth::user()->name ? (Auth::user()->name . ' Store') : 'Nama Toko',
            'focus' => '',
            'description' => '',
        ];
        $store = array_merge($defaults, session('seller_store', []));
        return view('seller.onboarding.info', compact('store'));
    })->name('seller.onboarding.info');

    Route::post('/seller/onboarding/info', function (Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'focus' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama toko wajib diisi.',
        ]);

        // Save into session so settings page stays in sync (no DB yet)
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name'])));
        $existing = session('seller_store', []);
        $store = array_merge([
            'slug' => $existing['slug'] ?? $slug,
            'logo' => $existing['logo'] ?? asset('image/ulos1.jpeg'),
            'address' => $existing['address'] ?? '',
            'phone' => $existing['phone'] ?? '',
            'email' => $existing['email'] ?? (Auth::user()->email ?? ''),
            'hours' => $existing['hours'] ?? '',
        ], $data);
        session(['seller_store' => $store]);

        return redirect()->route('seller.onboarding.address')->with('success', 'Informasi toko tersimpan. Lanjut isi alamat.');
    })->name('seller.onboarding.info.save');

    // Seller onboarding: step 2 - store address information
    Route::get('/seller/onboarding/address', function () {
        $defaults = [
            'province' => '',
            'city' => '',
            'district' => '',
            'postal_code' => '',
            'address' => '',
        ];
        $store = array_merge($defaults, session('seller_store', []));
        return view('seller.onboarding.address', compact('store'));
    })->name('seller.onboarding.address');

    Route::post('/seller/onboarding/address', function (Request $request) {
        $data = $request->validate([
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $existing = session('seller_store', []);
        $store = array_merge($existing, $data);
        session(['seller_store' => $store]);

        // Next step: bank information
        return redirect()->route('seller.onboarding.bank')->with('success', 'Alamat toko tersimpan. Lanjut isi informasi rekening.');
    })->name('seller.onboarding.address.save');

    // Seller onboarding: step 3 - bank information
    Route::get('/seller/onboarding/bank', function () {
        $defaults = [
            'bank_name' => '',
            'bank_account' => '',
            'bank_holder' => '',
        ];
        $store = array_merge($defaults, session('seller_store', []));
        return view('seller.onboarding.bank', compact('store'));
    })->name('seller.onboarding.bank');

    Route::post('/seller/onboarding/bank', function (Request $request) {
        $data = $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'bank_holder' => 'nullable|string|max:255',
        ]);

        $existing = session('seller_store', []);
        $store = array_merge($existing, $data);
        session(['seller_store' => $store]);

        // Next step: go to verification
        return redirect()->route('seller.onboarding.verify')->with('success', 'Informasi rekening tersimpan. Lanjut unggah dokumen verifikasi.');
    })->name('seller.onboarding.bank.save');

    // Seller onboarding: step 4 - verification documents
    Route::get('/seller/onboarding/verify', function () {
        $store = session('seller_store', []);
        return view('seller.onboarding.verify', compact('store'));
    })->name('seller.onboarding.verify');

    Route::post('/seller/onboarding/verify', function (Request $request) {
        $user = Auth::user();
        $store = session('seller_store', []);

        // Validate form data
        $data = $request->validate([
            'ktp_number' => ['required', 'regex:/^\d{16}$/'],
            'ktp_photo' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'selfie_photo' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'store_photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'ktp_number.required' => 'Nomor KTP wajib diisi.',
            'ktp_number.regex' => 'Nomor KTP harus 16 digit angka.',
            'ktp_photo.required' => 'Foto KTP wajib diunggah.',
            'selfie_photo.required' => 'Foto selfie dengan KTP wajib diunggah.',
        ]);

        // Create storage directory for user
        $userDir = 'seller_verification/' . $user->id;
        
        // Upload files to private storage
        $ktpPath = $request->file('ktp_photo')->store($userDir, 'private');
        $selfiePath = $request->file('selfie_photo')->store($userDir, 'private');
        $storePath = null;
        if ($request->hasFile('store_photo')) {
            $storePath = $request->file('store_photo')->store($userDir, 'private');
        }

        // Update user with verification data from onboarding + session
        $user->update([
            'ktp_number' => $data['ktp_number'],
            'phone_number' => $user->phone ?? '', // Use existing phone if available
            'store_name' => $store['name'] ?? ($user->name . ' Store'),
            'store_address' => $store['address'] ?? '',
            'bank_name' => $store['bank_name'] ?? '',
            'bank_account_number' => $store['account_number'] ?? '',
            'bank_account_name' => $store['account_name'] ?? '',
            'ktp_photo_path' => $ktpPath,
            'selfie_with_ktp_path' => $selfiePath,
            'store_photo_path' => $storePath,
            'verification_status' => 'pending',
            'verification_submitted_at' => now(),
        ]);

        // Clear session data after saving to database
        session()->forget('seller_store');

        return redirect()->route('seller.verification.pending')
            ->with('success', 'Dokumen verifikasi berhasil diunggah! Tim kami akan meninjau dalam 1-3 hari kerja.');
    })->name('seller.onboarding.verify.save');
});
// Dashboard penjual
Route::get('/seller/dashboard', function () {
    return view('seller.dashboard');
})->middleware(['auth', 'role:seller'])->name('seller.dashboard');

// Halaman daftar produk penjual
Route::get('/seller/products', function () {
    return view('seller.products.index');
})->middleware(['auth', 'role:seller'])->name('seller.products.index');

// Halaman tambah produk (form kosong mirip edit)
Route::get('/seller/products/create', function () {
    $product = [
        'name' => '',
        'category' => 'Pernikahan',
        'price' => '',
        'stock' => '',
        'description' => '',
        'material' => '',
        'size' => '',
        'weight' => '',
        'origin' => '',
        'status' => true,
        'images' => [],
    ];
    $slugValue = null; // belum ada slug sampai disimpan
    $uploaded = [];
    return view('seller.products.create', compact('product', 'slugValue', 'uploaded'));
})->middleware(['auth', 'role:seller'])->name('seller.products.create');

// Simpan produk baru (demo: ke session + simpan gambar)
Route::post('/seller/products', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'description' => 'nullable|string',
        'material' => 'nullable|string',
        'size' => 'nullable|string',
        'weight' => 'nullable|integer',
        'origin' => 'nullable|string',
        'status' => 'nullable|boolean',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
    ]);
    // fungsi slug sederhana
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name'])));
    $dir = 'public/products/' . $slug;
    $images = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $name = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($dir, $name);
            $images[] = asset('storage/products/' . $slug . '/' . $name);
        }
    }
    $custom = session()->get('custom_products', []);
    $custom[$slug] = [
        'title' => $data['name'],
        'slug' => $slug,
        'category' => $data['category'],
        'price' => (int) $data['price'],
        'stock' => (int) $data['stock'],
        'sold' => 0,
        'status' => $data['status'] ? 'Aktif' : 'Nonaktif',
        'img' => $images[0] ?? asset('image/ulos1.jpeg'),
    ];
    session()->put('custom_products', $custom);
    return redirect()->route('seller.products.edit', $slug)->with('success', 'Produk baru dibuat (demo).');
})->middleware(['auth', 'role:seller'])->name('seller.products.store');

// Halaman edit produk (placeholder berdasarkan slug)
Route::get('/seller/products/{slug}/edit', function ($slug) {
    // Data dummy untuk demo edit
    $products = [
        'ulos-ragihotang-premium' => [
            'name' => 'Ulos Ragihotang Premium',
            'category' => 'Pernikahan',
            'price' => 1250000,
            'stock' => 15,
            'description' => 'Ulos Ragihotang Premium adalah kain tenun tradisional Batak dengan teknik ikat benang premium.',
            'material' => 'Benang katun premium',
            'size' => '200cm x 100cm',
            'weight' => 500,
            'origin' => 'Sumatera Utara',
            'status' => true,
            'images' => [asset('image/Ulos Ragi Hotang.jpg')],
        ],
        'ulos-bintang-maratur-klasik' => [
            'name' => 'Ulos Bintang Maratur Klasik',
            'category' => 'Penghormatan',
            'price' => 950000,
            'stock' => 8,
            'description' => 'Ulos Bintang Maratur dengan motif klasik untuk acara penghormatan adat.',
            'material' => 'Benang katun premium',
            'size' => '190cm x 95cm',
            'weight' => 480,
            'origin' => 'Sumatera Utara',
            'status' => true,
            'images' => [asset('image/Ulos Bintang Maratur.jpg')],
        ],
        'ulos-sibolong-tradisional' => [
            'name' => 'Ulos Sibolong Tradisional',
            'category' => 'Kematian',
            'price' => 1100000,
            'stock' => 12,
            'description' => 'Ulos Sibolong tradisional digunakan dalam upacara kedukaan.',
            'material' => 'Katun tenun',
            'size' => '200cm x 110cm',
            'weight' => 520,
            'origin' => 'Sumatera Utara',
            'status' => true,
            // Perbaikan: file yang tersedia adalah 'Ulos Sibolang Rasta Pamontari.jpg'
            'images' => [asset('image/Ulos Sibolang Rasta Pamontari.jpg')],
        ],
        'ulos-ragi-hidup-eksklusif' => [
            'name' => 'Ulos Ragi Hidup Eksklusif',
            'category' => 'Pernikahan',
            'price' => 1350000,
            'stock' => 0,
            'description' => 'Versi eksklusif Ulos Ragi Hidup untuk seremoni adat istimewa.',
            'material' => 'Katun premium',
            'size' => '200cm x 100cm',
            'weight' => 530,
            'origin' => 'Sumatera Utara',
            'status' => false,
            'images' => [asset('image/ulos2.jpg')],
        ],
        'ulos-mangiring-premium' => [
            'name' => 'Ulos Mangiring Premium',
            'category' => 'Penghormatan',
            'price' => 875000,
            'stock' => 20,
            'description' => 'Ulos Mangiring bermotif khas untuk acara penghormatan keluarga.',
            'material' => 'Katun premium',
            'size' => '195cm x 100cm',
            'weight' => 500,
            'origin' => 'Sumatera Utara',
            'status' => true,
            'images' => [asset('image/ulos3.jpg')],
        ],
    ];

    if (!isset($products[$slug])) {
        abort(404);
    }

    $product = $products[$slug];
    // Ambil file yang sudah diupload untuk slug ini
    $uploaded = [];
    $dir = 'public/products/' . $slug;
    if (Storage::exists($dir)) {
        foreach (Storage::files($dir) as $f) {
            $uploaded[] = asset('storage/products/' . $slug . '/' . basename($f));
        }
    }
    $slugValue = $slug;
    return view('seller.products.edit', compact('product', 'slugValue', 'uploaded'));
})->middleware(['auth', 'role:seller'])->name('seller.products.edit');

// Upload gambar produk (multiple)
Route::post('/seller/products/{slug}/images', function (Request $request, $slug) {
    $request->validate([
        'images' => 'required|array',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'images.required' => 'Minimal satu gambar harus dipilih.',
        'images.*.image' => 'File harus berupa gambar.',
        'images.*.mimes' => 'Format yang diizinkan: JPG, JPEG, PNG.',
        'images.*.max' => 'Ukuran gambar maksimal 2MB.',
    ]);

    $dir = 'public/products/' . $slug;
    foreach ($request->file('images') as $file) {
        // Nama unik agar tidak tertimpa
        $name = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($dir, $name);
    }

    return redirect()->route('seller.products.edit', $slug)->with('success', 'Gambar berhasil diupload.');
})->middleware(['auth', 'role:seller'])->name('seller.products.images.upload');

// Hapus produk (demo: hanya menandai di session + hapus gambar yang diupload)
Route::delete('/seller/products/{slug}', function ($slug) {
    // Catat slug yang dihapus di session agar tidak tampil di daftar
    $deleted = session()->get('deleted_products', []);
    if (!in_array($slug, $deleted)) {
        $deleted[] = $slug;
        session()->put('deleted_products', $deleted);
    }
    // Hapus direktori gambar jika ada
    Storage::deleteDirectory('public/products/' . $slug);
    return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus (demo).');
})->middleware(['auth', 'role:seller'])->name('seller.products.destroy');

// Daftar pesanan
Route::get('/seller/orders', function () {
    return view('seller.orders.index');
})->middleware(['auth', 'role:seller'])->name('seller.orders.index');

// Laporan penjualan (seller reports)
Route::get('/seller/laporan', function () {
    return view('seller.reports.index');
})->middleware(['auth', 'role:seller'])->name('seller.reports.index');

// Pengaturan toko (seller settings)
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller/settings', function () {
        $defaults = [
            'name' => Auth::user()->name ? (Auth::user()->name . ' Store') : 'Nama Toko',
            'slug' => 'toko-anda',
            'description' => 'Deskripsi singkat toko ulos Anda.',
            'logo' => asset('image/ulos1.jpeg'),
            'address' => '',
            'phone' => '',
            'email' => Auth::user()->email ?? '',
            'hours' => '',
            'focus' => '',
        ];
        $store = array_merge($defaults, session('seller_store', []));
        return view('seller.settings', compact('store'));
    })->name('seller.settings');

    Route::post('/seller/settings', function (Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'hours' => 'nullable|string|max:255',
            'focus' => 'nullable|string|max:255',
        ]);

        $existing = session('seller_store', []);
        $slug = $existing['slug'] ?? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name'])));
        $store = array_merge($existing, $data, [
            'slug' => $slug,
        ]);
        session(['seller_store' => $store]);

        return redirect()->route('seller.settings')->with('success', 'Pengaturan toko disimpan.');
    })->name('seller.settings.save');
});

// Seller Verification Routes
Route::middleware(['auth', 'role:seller'])->group(function () {
    // Verification form page (for new submission or resubmission after rejection)
    Route::get('/seller/verification', function () {
        $user = Auth::user();
        
        // If already verified, redirect to dashboard
        if ($user->verification_status === 'approved') {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Akun Anda sudah terverifikasi.');
        }
        
        // If pending, redirect to pending page
        if ($user->verification_status === 'pending') {
            return redirect()->route('seller.verification.pending');
        }
        
        // Show verification form (for first-time or rejected users)
        return redirect()->route('seller.onboarding.verify');
    })->name('seller.verification');
    
    // Verification pending page
    Route::get('/seller/verification/pending', function () {
        $user = Auth::user();
        
        // If not submitted verification yet or rejected, redirect to verification form
        if (!$user->verification_status || $user->verification_status === 'rejected') {
            return redirect()->route('seller.verification');
        }
        
        // If already verified, redirect to dashboard
        if ($user->verification_status === 'approved') {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Akun Anda sudah terverifikasi.');
        }
        
        return view('seller.verification-pending');
    })->name('seller.verification.pending');
    
    // AJAX endpoint for checking verification status
    Route::get('/seller/verification/status', function () {
        $user = Auth::user();
        
        return response()->json([
            'status' => $user->verification_status,
            'submitted_at' => $user->verification_submitted_at ? $user->verification_submitted_at->format('Y-m-d H:i:s') : null,
            'approved_at' => $user->verification_approved_at ? $user->verification_approved_at->format('Y-m-d H:i:s') : null,
            'rejected_at' => $user->verification_rejected_at ? $user->verification_rejected_at->format('Y-m-d H:i:s') : null,
            'rejection_reason' => $user->rejection_reason,
        ]);
    })->name('seller.verification.status');
});

// Admin Routes for Seller Verification  
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin verification list
    Route::get('/admin/verification', function () {
        $users = \App\Models\User::where('role', 'seller')
            ->whereNotNull('verification_status')
            ->orderByRaw("FIELD(verification_status, 'pending', 'approved', 'rejected')")
            ->orderBy('verification_submitted_at', 'desc')
            ->get();
        
        return view('admin.verification-list', compact('users'));
    })->name('admin.verification.list');
    
    // Admin verification detail
    Route::get('/admin/verification/{user}', function (\App\Models\User $user) {
        if ($user->role !== 'seller') {
            abort(404);
        }
        
        return view('admin.verification-detail', compact('user'));
    })->name('admin.verification.detail');
    
    // Admin approve verification
    Route::post('/admin/verification/{user}/approve', function (\App\Models\User $user) {
        if ($user->role !== 'seller' || $user->verification_status !== 'pending') {
            return redirect()->back()->with('error', 'Verifikasi tidak valid.');
        }
        
        $user->update([
            'verification_status' => 'approved',
            'verification_approved_at' => now(),
            'verification_rejected_at' => null,
            'rejection_reason' => null,
        ]);
        
        // Send approval email
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SellerApprovedMail($user));
        } catch (\Exception $e) {
            // Log error but don't block the approval
            \Log::error('Failed to send approval email: ' . $e->getMessage());
        }
        
        return redirect()->route('admin.verification.list')
            ->with('success', 'Verifikasi seller berhasil disetujui! Email notifikasi telah dikirim.');
    })->name('admin.verification.approve');
    
    // Admin reject verification
    Route::post('/admin/verification/{user}/reject', function (\App\Models\User $user, Request $request) {
        if ($user->role !== 'seller' || $user->verification_status !== 'pending') {
            return redirect()->back()->with('error', 'Verifikasi tidak valid.');
        }
        
        $reason = $request->input('rejection_reason', 'Dokumen tidak memenuhi persyaratan');
        
        $user->update([
            'verification_status' => 'rejected',
            'verification_approved_at' => null,
            'verification_rejected_at' => now(),
            'rejection_reason' => $reason,
        ]);
        
        // Send rejection email
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SellerRejectedMail($user, $reason));
        } catch (\Exception $e) {
            // Log error but don't block the rejection
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }
        
        return redirect()->route('admin.verification.list')
            ->with('success', 'Verifikasi seller ditolak. Email notifikasi telah dikirim.');
    })->name('admin.verification.reject');
    
    // Admin view private documents
    Route::get('/admin/verification/{user}/document/{type}', function (\App\Models\User $user, $type) {
        if ($user->role !== 'seller') {
            abort(404);
        }
        
        $path = null;
        switch ($type) {
            case 'ktp':
                $path = $user->ktp_photo_path;
                break;
            case 'selfie':
                $path = $user->selfie_with_ktp_path;
                break;
            case 'store':
                $path = $user->store_photo_path;
                break;
            default:
                abort(404);
        }
        
        if (!$path || !Storage::disk('private')->exists($path)) {
            abort(404);
        }
        
        return Storage::disk('private')->response($path);
    })->name('admin.verification.document');
});

// Google OAuth Routes (harus di LUAR middleware auth)
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Facebook OAuth Routes
Route::get('/auth/facebook', [FacebookController::class, 'redirect'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [FacebookController::class, 'callback'])->name('auth.facebook.callback');

// API Routes for Facebook Authentication
Route::prefix('api/auth')->group(function () {
    Route::get('/facebook/redirect', [FacebookController::class, 'apiRedirect'])->name('api.auth.facebook.redirect');
    Route::get('/facebook/callback', [FacebookController::class, 'apiCallback'])->name('api.auth.facebook.callback');
});
