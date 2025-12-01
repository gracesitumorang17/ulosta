<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function billingAddresses()
    {
        return $this->hasMany(Address::class)->billing();
    }

    public function shippingAddresses()
    {
        return $this->hasMany(Address::class)->shipping();
    }

    public function defaultBillingAddress()
    {
        return $this->hasOne(Address::class)->billing()->default();
    }

    public function defaultShippingAddress()
    {
        return $this->hasOne(Address::class)->shipping()->default();
    }

    // Accessors
    public function getCartTotalAttribute()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    public function getCartCountAttribute()
    {
        return $this->cartItems->sum('quantity');
    }

    public function getFormattedCartTotalAttribute()
    {
        return 'Rp ' . number_format($this->cart_total, 0, ',', '.');
    }
}
