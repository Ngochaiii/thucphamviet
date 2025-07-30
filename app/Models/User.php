<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable , HasApiTokens;

    protected $fillable = [
        'email',
        'password',
        'phone',
        'role',
        'is_active',
        'last_name',
        'first_name',
        'display_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'role' => 'integer',
    ];

    // Relationships
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function savedCards(): HasMany
    {
        return $this->hasMany(PaymentMethod::class)->where('type', 'credit_card');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->role === 1;
    }

    public function getIsCustomerAttribute(): bool
    {
        return $this->role === 0;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCustomers($query)
    {
        return $query->where('role', 0);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 1);
    }

    // Methods
    public function getActiveCart()
    {
        return $this->carts()->first();
    }

    public function getDefaultPaymentMethod()
    {
        return $this->paymentMethods()->where('is_default', true)->first();
    }
}
