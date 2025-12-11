<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'product_image',
        'quantity',
        'price',
        'subtotal',
        'total',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    // Methods
    public function calculateTotal()
    {
        $this->total = $this->quantity * $this->price;
        return $this->total;
    }

    // Boot method to calculate total automatically
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            $calc = $orderItem->quantity * $orderItem->price;
            // Isi subtotal jika belum dikirim dari controller
            if (is_null($orderItem->subtotal)) {
                $orderItem->subtotal = $calc;
            }
            $orderItem->total = $calc;
        });
    }
}
