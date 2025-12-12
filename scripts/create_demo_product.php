<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

// Boot Laravel framework minimal - use Artisan's bootstrap
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Now we can use models
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;

// Find or create seller
$seller = User::where('role', 'seller')->first();
if (! $seller) {
    $seller = User::create([
        'name' => 'Demo Seller',
        'email' => 'seller@example.test',
        'password' => bcrypt('password'),
        'role' => 'seller',
    ]);
}

$product = Product::create([
    'name' => 'Ulos Demo - Songket Motif',
    'slug' => Str::slug('Ulos Demo - Songket Motif') . '-' . Str::random(5),
    'description' => 'Produk demo untuk pengujian seller orders.',
    'price' => 150000,
    'original_price' => 200000,
    'stock' => 10,
    'is_active' => true,
    'seller_id' => $seller->id,
    'image' => null,
]);

echo "CREATED: product_id={$product->id} seller_id={$seller->id}\n";
