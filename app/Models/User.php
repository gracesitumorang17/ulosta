<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

    public function getCartTotalAttribute()
    {
        return $this->cartItems->sum(fn($item) => $item->quantity * $item->price);
    }

    public function getCartCountAttribute()
    {
        return $this->cartItems->sum('quantity');
    }

    public function getFormattedCartTotalAttribute()
    {
        return 'Rp ' . number_format($this->cart_total, 0, ',', '.');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }
}
