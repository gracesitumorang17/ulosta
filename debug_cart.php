<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$kernel->bootstrap();

use App\Models\CartItem;
use App\Models\Product;

echo "=== CART ITEMS ===\n";
$items = CartItem::all();
foreach ($items as $item) {
    echo "ID: {$item->id}, Product ID: {$item->product_id}, Product Name: {$item->product_name}, Image: {$item->image}\n";
}

echo "\n=== PRODUCTS ===\n";
$products = Product::all();
foreach ($products as $product) {
    echo "ID: {$product->id}, Name: {$product->name}, Image: {$product->image}\n";
}

echo "\n=== CART ITEMS WITH PRODUCT ===\n";
$items = CartItem::with('product')->get();
foreach ($items as $item) {
    echo "Cart ID: {$item->id}, Product ID: {$item->product_id}\n";
    if ($item->product) {
        echo "  Product Found: {$item->product->name}, Image: {$item->product->image}\n";
    } else {
        echo "  Product NOT FOUND\n";
    }
}
