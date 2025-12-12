<?php

// routes/debug.php - tambahkan ke web.php untuk debug

Route::get('/debug-cart', function () {
    $items = \App\Models\CartItem::where('user_id', auth()->id())->with('product')->get();

    echo "<h1>Cart Items Debug</h1>";

    foreach ($items as $item) {
        echo "<hr>";
        echo "<b>Item ID:</b> {$item->id}<br>";
        echo "<b>Product ID:</b> {$item->product_id}<br>";
        echo "<b>Product Name:</b> {$item->product_name}<br>";
        echo "<b>Image (raw):</b> {$item->image}<br>";

        if ($item->product) {
            echo "<b>Product Image:</b> {$item->product->image}<br>";
            echo "<b>Product Image URL:</b> {$item->product->image_url}<br>";
        }

        // Test paths
        if ($item->image) {
            if (strpos($item->image, '/') !== false) {
                echo "<b>Has slash - will use Storage::url</b><br>";
                echo "<b>Storage URL:</b> " . \Illuminate\Support\Facades\Storage::url($item->image) . "<br>";
            } else {
                echo "<b>No slash - will use asset('image/')</b><br>";
                echo "<b>Asset URL:</b> " . asset('image/' . $item->image) . "<br>";
            }
        }
    }
});
