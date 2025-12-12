<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$kernel->bootstrap();

use App\Models\Wishlist;

echo "=== WISHLIST ITEMS ===\n";
$wishlists = Wishlist::all();

foreach ($wishlists as $item) {
    echo "\nID: {$item->id}\n";
    echo "Product Name: {$item->product_name}\n";
    echo "Product Image: {$item->product_image}\n";
    echo "---\n";
}
