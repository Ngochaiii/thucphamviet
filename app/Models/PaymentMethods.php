<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethods extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'name',
        'description',
        'card_number_masked',
        'card_holder_name',
        'expiry_date',
        'is_default',
        'is_active',
        'processing_fee',
        'sort_order',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'processing_fee' => 'decimal:2',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeSystemMethods($query)
    {
        return $query->whereNull('user_id');
    }

    public function scopeUserMethods($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Methods
    public function isSystemMethod(): bool
    {
        return is_null($this->user_id);
    }

    public function isUserMethod(): bool
    {
        return !is_null($this->user_id);
    }

    public function calculateProcessingFee(float $amount): float
    {
        return $amount * ($this->processing_fee / 100);
    }
}
