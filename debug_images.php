<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$kernel->bootstrap();

use App\Models\CartItem;
use Illuminate\Support\Facades\Storage;

echo "=== TESTING CART ITEMS ===\n";
$items = CartItem::with('product')->get();

foreach ($items as $item) {
    echo "\n--- Cart Item ID: {$item->id} ---\n";
    echo "Product ID: {$item->product_id}\n";
    echo "Product Name: {$item->product_name}\n";
    echo "Image (raw): {$item->image}\n";

    if ($item->product) {
        echo "Product Image: {$item->product->image}\n";
        echo "Product Image URL: {$item->product->image_url}\n";
    }

    // Test Storage::url
    if (!empty($item->image)) {
        if (strpos($item->image, '/') !== false) {
            $storageUrl = Storage::url($item->image);
            echo "Storage::url result: $storageUrl\n";
        } else {
            $assetUrl = asset('image/' . $item->image);
            echo "asset('image/...') result: $assetUrl\n";
        }
    }
}
