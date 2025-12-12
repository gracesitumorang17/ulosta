<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'user_id',
        'order_number',
        'order_code',
        'status',
        'payment_status',
        'payment_method',
        'shipping_method',
        'subtotal',
        'shipping_cost',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'total_price',
        'currency',
        'notes',
        'shipped_at',
        'delivered_at',

        // Payment verification metadata
        'payment_verified_by',
        'payment_verified_at',
        'payment_proof_url',
        'payment_proof_note',
        'payment_proof_submitted_at',

        // Billing Address
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'billing_country',

        // Shipping Address
        'shipping_first_name',
        'shipping_last_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'payment_verified_at' => 'datetime',
        'payment_proof_submitted_at' => 'datetime',
    ];

    // Order statuses
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';

    // Payment statuses
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_REFUNDED = 'refunded';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessors
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getFormattedShippingCostAttribute()
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    public function getBillingFullNameAttribute()
    {
        return $this->billing_first_name . ' ' . $this->billing_last_name;
    }

    public function getShippingFullNameAttribute()
    {
        return $this->shipping_first_name . ' ' . $this->shipping_last_name;
    }

    public function getBillingFullAddressAttribute()
    {
        $address = $this->billing_address_1;
        if ($this->billing_address_2) {
            $address .= ', ' . $this->billing_address_2;
        }
        $address .= ', ' . $this->billing_city . ', ' . $this->billing_state . ' ' . $this->billing_postal_code;
        return $address;
    }

    public function getShippingFullAddressAttribute()
    {
        $address = $this->shipping_address_1;
        if ($this->shipping_address_2) {
            $address .= ', ' . $this->shipping_address_2;
        }
        $address .= ', ' . $this->shipping_city . ', ' . $this->shipping_state . ' ' . $this->shipping_postal_code;
        return $address;
    }

    public function getItemsCountAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    public function scopeShipped($query)
    {
        return $query->where('status', self::STATUS_SHIPPED);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }

    // Methods
    public function calculateTotal()
    {
        $this->subtotal = $this->orderItems()->sum(\DB::raw('quantity * price'));
        $this->total_amount = $this->subtotal + $this->shipping_cost + $this->tax_amount - $this->discount_amount;
        $this->save();
    }

    public static function generateOrderNumber()
    {
        $prefix = 'UL-';
        $date = now()->format('Ymd');
        $lastOrder = static::whereDate('created_at', today())
            ->where('order_number', 'like', $prefix . $date . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $date . $newNumber;
    }
}
