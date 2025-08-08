<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_jp_name',
        'product_slug',
        'product_image',
        'unit_price',
        'quantity',
        'discount_percent',
        'discount_amount',
        'line_total',
        'product_weight',
        'product_category',
        'product_unit',
        'product_unit_display',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'line_total' => 'decimal:2',
        'product_weight' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Auto calculate line_total khi save
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            // Tính line_total nếu chưa có
            if (!$orderItem->line_total) {
                $subtotal = $orderItem->unit_price * $orderItem->quantity;
                $discount = $orderItem->discount_amount ?:
                           ($subtotal * $orderItem->discount_percent / 100);
                $orderItem->line_total = $subtotal - $discount;
                $orderItem->discount_amount = $discount;
            }
        });

        static::saved(function ($orderItem) {
            // Update order totals
            $orderItem->order->recalculateOrderTotals();
        });

        static::deleted(function ($orderItem) {
            // Update order totals
            $orderItem->order->recalculateOrderTotals();
        });
    }

    // Scopes
    public function scopeByOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    // Accessors
    public function getOriginalPriceAttribute()
    {
        return $this->unit_price * $this->quantity;
    }

    public function getTotalDiscountAttribute()
    {
        return $this->discount_amount;
    }

    public function getFinalPriceAttribute()
    {
        return $this->line_total;
    }

    public function getFormattedUnitPriceAttribute()
    {
        return '¥ ' . number_format($this->unit_price);
    }

    public function getFormattedLineTotalAttribute()
    {
        return '¥ ' . number_format($this->line_total);
    }

    public function getTotalWeightAttribute()
    {
        return $this->quantity * ($this->product_weight ?? 0);
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price > 0) {
            return ($this->discount_amount / $this->original_price) * 100;
        }
        return 0;
    }

    // Methods
    public function updateQuantity($newQuantity)
    {
        if ($newQuantity <= 0) {
            $this->delete();
            return;
        }

        $subtotal = $this->unit_price * $newQuantity;
        $discount = $subtotal * ($this->discount_percent / 100);

        $this->update([
            'quantity' => $newQuantity,
            'discount_amount' => $discount,
            'line_total' => $subtotal - $discount
        ]);
    }

    public function applyDiscount($discountPercent)
    {
        $subtotal = $this->unit_price * $this->quantity;
        $discount = $subtotal * ($discountPercent / 100);

        $this->update([
            'discount_percent' => $discountPercent,
            'discount_amount' => $discount,
            'line_total' => $subtotal - $discount
        ]);
    }
}
