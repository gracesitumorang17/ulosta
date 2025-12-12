<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get image URL untuk cart/wishlist items
     * Menangani tiga jenis format:
     * 1. Storage path relative: "products/20/..."
     * 2. Simple filename: "Ulos Sadum.jpeg"
     * 3. Full URL: "http://..." atau "https://..."
     */
    public static function getImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return asset('image/Background.png');
        }

        // Check if it's already a full URL
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            // Return as-is (already a full URL)
            return $imagePath;
        }

        // Check if it's a storage path (contains /)
        if (strpos($imagePath, '/') !== false) {
            // Storage path like "products/20/..."
            return Storage::url($imagePath);
        } else {
            // Simple filename like "Ulos Sadum.jpeg"
            return asset('image/' . $imagePath);
        }
    }
}

