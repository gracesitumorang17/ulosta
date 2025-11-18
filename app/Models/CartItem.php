<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'product_name', 'tag', 'image', 'quantity', 'price', 'original_price'
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
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price ? 'Rp ' . number_format($this->original_price, 0, ',', '.') : null;
    }

    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getDiscountAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return $this->original_price - $this->price;
        }
        return 0;
    }

    public function getFormattedDiscountAttribute()
    {
        return 'Rp ' . number_format($this->discount, 0, ',', '.');
    }
}
