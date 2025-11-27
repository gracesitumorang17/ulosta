<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        'tags' => ['Ragi Hotang', 'Pernikahan'],
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
        ['title' => 'Ulos Bintang Maratur', 'price' => 750000, 'old' => 900000, 'img' => asset('image/Ulos Bintang Maratur.jpg'), 'tag' => 'Kelahiran'],
        ['title' => 'Ulos Mangiring', 'price' => 860000, 'old' => 990000, 'img' => asset('image/Ulos Mangiring.jpg'), 'tag' => 'Pernikahan'],
        ['title' => 'Ulos Sibolang Rasta Pamontari', 'price' => 750000, 'old' => 1000000, 'img' => asset('image/Ulos Sibolang Rasta Pamontari.jpg'), 'tag' => 'Kelahiran'],
    ];

    return view('produk.detail', compact('product', 'recommendations'));
})->name('produk.detail');
// Cart routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::patch('/cart/{item}/qty', [CartController::class, 'updateQty'])->name('cart.qty');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.delete');
});

// ========== Seller area (basic auth-protected routes) ==========
// Dashboard penjual
Route::get('/seller/dashboard', function () {
    return view('seller.dashboard');
})->middleware('auth')->name('seller.dashboard');

// Halaman daftar produk penjual
Route::get('/seller/products', function () {
    return view('seller.products.index');
})->middleware('auth')->name('seller.products.index');

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
})->middleware('auth')->name('seller.products.create');

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
})->middleware('auth')->name('seller.products.store');

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
})->middleware('auth')->name('seller.products.edit');

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
})->middleware('auth')->name('seller.products.images.upload');

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
})->middleware('auth')->name('seller.products.destroy');

// Daftar pesanan
Route::get('/seller/orders', function () {
    return view('seller.orders.index');
})->middleware('auth')->name('seller.orders.index');

// Laporan penjualan (seller reports)
Route::get('/seller/laporan', function () {
    return view('seller.reports.index');
})->middleware('auth')->name('seller.reports.index');

// Pengaturan toko (seller settings)
Route::get('/seller/settings', function () {
    // Data placeholder dapat digantikan dengan data toko nyata nanti
    $store = [
        'name' => Auth::user()->name ?? 'Nama Toko',
        'slug' => 'toko-anda',
        'description' => 'Deskripsi singkat toko ulos Anda.',
        'logo' => asset('image/ulos1.jpeg'),
    ];
    return view('seller.settings', compact('store'));
})->middleware('auth')->name('seller.settings');
