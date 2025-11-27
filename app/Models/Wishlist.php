<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_name',
        'product_image',
        'product_price',
        'product_original_price',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'product_original_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->product_price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return $this->product_original_price ? 'Rp ' . number_format($this->product_original_price, 0, ',', '.') : null;
    }
}
