<?php

// ===== MODEL CART ITEM =====
// app/Models/CartItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    /**
     * Các field có thể mass assignment
     */
    protected $fillable = [
        'cart_id',     // ID cart chứa item này
        'product_id',  // ID sản phẩm
        'quantity',    // Số lượng
        'unit_price',  // Giá đơn vị snapshot
        'line_total'   // Tổng tiền dòng
    ];

    /**
     * Cast các field về đúng kiểu dữ liệu
     */
    protected $casts = [
        'cart_id' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    // ===== RELATIONSHIPS =====

    /**
     * Item thuộc về một cart
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Item thuộc về một product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ===== METHODS =====

    /**
     * Cập nhật số lượng và tính lại line_total
     */
    public function updateQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
        $this->line_total = $this->quantity * $this->unit_price;
        $this->save();
    }

    /**
     * Tăng số lượng
     */
    public function incrementQuantity(int $amount = 1): void
    {
        $this->updateQuantity($this->quantity + $amount);
    }

    /**
     * Giảm số lượng
     */
    public function decrementQuantity(int $amount = 1): void
    {
        $newQuantity = max(1, $this->quantity - $amount);
        $this->updateQuantity($newQuantity);
    }

    // ===== EVENTS =====

    /**
     * Boot method - xử lý events
     */
    protected static function boot()
    {
        parent::boot();

        // Khi tạo mới → tự động tính line_total
        static::creating(function ($cartItem) {
            $cartItem->line_total = $cartItem->quantity * $cartItem->unit_price;
        });

        // Khi cập nhật → tự động tính lại line_total
        static::updating(function ($cartItem) {
            if ($cartItem->isDirty(['quantity', 'unit_price'])) {
                $cartItem->line_total = $cartItem->quantity * $cartItem->unit_price;
            }
        });

        // Sau khi lưu → cập nhật cart totals
        static::saved(function ($cartItem) {
            $cartItem->cart->updateTotals();
        });

        // Sau khi xóa → cập nhật cart totals
        static::deleted(function ($cartItem) {
            $cartItem->cart->updateTotals();
        });
    }
}


