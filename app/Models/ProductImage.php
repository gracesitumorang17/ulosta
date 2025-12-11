<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'seller_id',
        'path',
        'is_primary',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function getUrlAttribute(): string
    {
        $p = $this->path;
        if (!$p) {
            return asset('image/ulos1.jpeg');
        }
        if (is_string($p) && (str_starts_with($p, 'http://') || str_starts_with($p, 'https://'))) {
            return $p;
        }
        return asset('storage/' . ltrim($p, '/'));
    }
}
