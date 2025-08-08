<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'payment_method_id',
        'shipping_rate_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_province',
        'delivery_city',
        'delivery_address',
        'delivery_time_frame',
        'subtotal',
        'shipping_fee',
        'processing_fee',
        'discount_amount',
        'total_amount',
        'status',
        'payment_status',
        'is_guest_order',
        'order_notes',
        'admin_notes',
    ];
    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_guest_order' => 'boolean',
        'order_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];
    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethods(): BelongsTo
    {
        return $this->belongsTo(PaymentMethods::class);
    }

    public function shippingRate(): BelongsTo // Thêm relationship này
    {
        return $this->belongsTo(ShippingRate::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Tính tổng order với shipping
    public function calculateTotal()
    {
        $shippingFee = $this->shippingRate ? $this->shippingRate->base_fee : 0;
        $processingFee = $this->paymentMethod->calculateProcessingFee($this->subtotal);

        $this->update([
            'shipping_fee' => $shippingFee, // Lưu snapshot
            'processing_fee' => $processingFee,
            'total_amount' => $this->subtotal + $shippingFee + $processingFee - $this->discount_amount
        ]);
    }

    // Accessor để lấy thông tin shipping
    public function getShippingInfoAttribute()
    {
        if ($this->shippingRate) {
            return [
                'zone_name' => $this->shippingRate->zone_name,
                'delivery_days' => $this->shippingRate->delivery_days,
                'fee' => $this->shipping_fee
            ];
        }

        return null;
    }
    // Calculated properties từ order items
    public function getTotalItemsAttribute()
    {
        return $this->orderItems->sum('quantity');
    }

    public function getItemsCountAttribute()
    {
        return $this->orderItems->count();
    }

    public function getCalculatedSubtotalAttribute()
    {
        return $this->orderItems->sum('line_total');
    }

    public function getTotalWeightAttribute()
    {
        return $this->orderItems->sum('total_weight');
    }

    // Recalculate order totals từ items
    public function recalculateOrderTotals()
    {
        $items = $this->orderItems;
        $subtotal = $items->sum('line_total');

        // Tính lại các phí
        $shippingFee = $this->shippingRate ? $this->shippingRate->base_fee : $this->shipping_fee;
        $processingFee = $this->paymentMethod ?
            $this->paymentMethod->calculateProcessingFee($subtotal) :
            $this->processing_fee;

        $this->update([
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'processing_fee' => $processingFee,
            'total_amount' => $subtotal + $shippingFee + $processingFee - $this->discount_amount
        ]);
    }

    // Add items to order
    public function addItem($product, $quantity, $unitPrice = null, $discountPercent = 0)
    {
        $unitPrice = $unitPrice ?: $product->price;

        return $this->orderItems()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_jp_name' => $product->jp_name,
            'product_slug' => $product->slug,
            'product_image' => $product->image,
            'unit_price' => $unitPrice,
            'quantity' => $quantity,
            'discount_percent' => $discountPercent,
            'product_weight' => $product->weight_per_unit,
            'product_category' => $product->category->name ?? '',
            'product_unit' => $product->unit->name ?? '',
            'product_unit_display' => $product->unit->symbol ?? '',
        ]);
    }
}
