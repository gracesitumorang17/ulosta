<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'first_name',
        'last_name',
        'company',
        'address_1',
        'address_2',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // Address types
    const TYPE_BILLING = 'billing';
    const TYPE_SHIPPING = 'shipping';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address_1;
        if ($this->address_2) {
            $address .= ', ' . $this->address_2;
        }
        if ($this->company) {
            $address = $this->company . ', ' . $address;
        }
        $address .= ', ' . $this->city . ', ' . $this->state . ' ' . $this->postal_code;
        if ($this->country) {
            $address .= ', ' . $this->country;
        }
        return $address;
    }

    // Scopes
    public function scopeBilling($query)
    {
        return $query->where('type', self::TYPE_BILLING);
    }

    public function scopeShipping($query)
    {
        return $query->where('type', self::TYPE_SHIPPING);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        // Ensure only one default address per type per user
        static::saving(function ($address) {
            if ($address->is_default) {
                static::where('user_id', $address->user_id)
                      ->where('type', $address->type)
                      ->where('id', '!=', $address->id ?? 0)
                      ->update(['is_default' => false]);
            }
        });
    }
}