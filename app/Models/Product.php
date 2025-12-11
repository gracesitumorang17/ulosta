<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'material',
        'size',
        'weight',
        'origin',
        'price',
        'original_price',
        'tag',
        'category',
        'image',
        'stock',
        'is_active',
        'seller_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            // Saat seller membuat produk via UI, pastikan seller_id terisi otomatis
            if (empty($product->seller_id) && function_exists('auth') && auth()->check()) {
                $product->seller_id = auth()->id();
            }
        });
    }

    // Relationships
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        $img = $this->image;
        if (!$img) {
            // Try primary image from gallery
            $primary = $this->images()->where('is_primary', true)->first();
            if ($primary && $primary->path) {
                return asset('storage/' . ltrim($primary->path, '/'));
            }
            return asset('image/ulos1.jpeg');
        }
        // If already an absolute URL
        if (is_string($img) && (str_starts_with($img, 'http://') || str_starts_with($img, 'https://'))) {
            return $img;
        }
        // Stored relative path like products/<slug>/<file>
        return asset('storage/' . ltrim($img, '/'));
    }
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return 'Rp ' . number_format($this->original_price, 0, ',', '.');
        }
        return null;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('tag', 'like', "%{$search}%");
        });
    }
}
