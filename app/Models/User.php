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
        'google_id',
        'google_token',
        'google_refresh_token',
        'facebook_id',
        'facebook_token',
        'provider',
        'provider_id',
        'avatar',
        // Seller verification fields
        'verification_status',
        'ktp_number',
        'ktp_photo_path',
        'store_name',
        'store_address',
        'store_photo_path',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'selfie_with_ktp_path',
        'verification_submitted_at',
        'verification_approved_at',
        'verification_rejected_at',
        'rejection_reason',
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
            'verification_submitted_at' => 'datetime',
            'verification_approved_at' => 'datetime',
            'verification_rejected_at' => 'datetime',
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

    // Seller Verification Methods
    public function isPendingVerification(): bool
    {
        return $this->verification_status === 'pending';
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->verification_status === 'rejected';
    }

    public function hasCompleteDocuments(): bool
    {
        return !empty($this->ktp_number) && 
               !empty($this->ktp_photo_path) && 
               !empty($this->selfie_with_ktp_path) &&
               !empty($this->store_name) &&
               !empty($this->store_address) &&
               !empty($this->bank_name) &&
               !empty($this->bank_account_number) &&
               !empty($this->bank_account_name);
    }

    public function canAccessSellerFeatures(): bool
    {
        return $this->isSeller() && $this->isVerified();
    }
}
