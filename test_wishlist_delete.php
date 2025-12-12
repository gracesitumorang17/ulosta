<?php
// Test script untuk check wishlist delete

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

// Simulate Auth
$user = \App\Models\User::first();

echo "=== WISHLIST DEBUG ===\n";
echo "User ID: " . ($user ? $user->id : 'NO USER') . "\n";

if ($user) {
    Auth::loginUsingId($user->id);

    $wishlists = Wishlist::where('user_id', $user->id)->get();
    echo "Wishlist count for user: " . $wishlists->count() . "\n";

    foreach ($wishlists as $wl) {
        echo "- ID: {$wl->id}, User: {$wl->user_id}, Name: {$wl->product_name}\n";
    }

    // Test delete
    if ($wishlists->count() > 0) {
        $first = $wishlists->first();
        echo "\nTesting delete of ID: {$first->id}\n";

        $deleted = $first->delete();
        echo "Delete result: " . ($deleted ? 'SUCCESS' : 'FAILED') . "\n";

        $count = Wishlist::where('user_id', $user->id)->count();
        echo "New count: $count\n";
    }
}
