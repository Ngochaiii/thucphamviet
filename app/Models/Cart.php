<?php

// ===== MODEL CART =====
// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    /**
     * Các field có thể mass assignment
     */
    protected $fillable = [
        'user_id',      // ID user đã login (NULL cho guest)
        'session_id',   // Session ID cho guest user
        'subtotal',     // Tổng tiền
        'total_item',   // Tổng số lượng sản phẩm
        'status'        // Trạng thái cart
    ];

    /**
     * Cast các field về đúng kiểu dữ liệu
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'total_item' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Các giá trị mặc định
     */
    protected $attributes = [
        'subtotal' => 0,
        'total_item' => 0,
        'status' => 'active',
    ];

    // ===== RELATIONSHIPS =====

    /**
     * Một cart có nhiều cart items
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Cart thuộc về một user (nullable)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ===== SCOPES =====

    /**
     * Scope: Chỉ lấy cart đang active
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Lấy cart của user cụ thể (logged hoặc guest)
     */
    public function scopeForCurrentUser($query)
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        return $query->where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                // User đã login
                $q->where('user_id', $userId);
            } else {
                // Guest user
                $q->where('session_id', $sessionId)
                  ->whereNull('user_id');
            }
        });
    }

    /**
     * Scope: Lấy cart theo user hoặc session cụ thể
     */
    public function scopeForUser($query, $userId = null, $sessionId = null)
    {
        return $query->where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } elseif ($sessionId) {
                $q->where('session_id', $sessionId)
                  ->whereNull('user_id');
            }
        });
    }

    /**
     * Scope: Tìm cart abandoned (bỏ rơi > X ngày)
     */
    public function scopeAbandoned($query, $days = 7)
    {
        return $query->where('status', 'active')
                    ->where('updated_at', '<', now()->subDays($days));
    }

    // ===== METHODS =====

    /**
     * Tự động cập nhật tổng tiền và số lượng
     */
    public function updateTotals(): void
    {
        $this->subtotal = $this->items->sum('line_total');
        $this->total_item = $this->items->sum('quantity');
        $this->save();
    }

    /**
     * Kiểm tra cart có trống không
     */
    public function isEmpty(): bool
    {
        return $this->items->count() === 0;
    }

    /**
     * Xóa tất cả items trong cart
     */
    public function clearItems(): void
    {
        $this->items()->delete();
        $this->updateTotals();
    }

    /**
     * Đánh dấu cart là completed
     */
    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Đánh dấu cart là abandoned
     */
    public function markAsAbandoned(): void
    {
        $this->update(['status' => 'abandoned']);
    }

    /**
     * Lấy hoặc tạo cart cho user hiện tại
     */
    public static function getOrCreateForCurrentUser(): self
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        $cart = self::active()
                   ->forUser($userId, $sessionId)
                   ->first();

        if (!$cart) {
            $cart = self::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
            ]);
        }

        return $cart;
    }

    /**
     * Merge guest cart vào user cart khi login
     */
    public static function mergeGuestCartToUser($userId): void
    {
        $sessionId = Session::getId();

        $guestCart = self::where('session_id', $sessionId)
                        ->whereNull('user_id')
                        ->where('status', 'active')
                        ->first();

        if (!$guestCart) {
            return;
        }

        $userCart = self::where('user_id', $userId)
                       ->where('status', 'active')
                       ->first();

        if ($userCart) {
            // Merge items từ guest cart vào user cart
            foreach ($guestCart->items as $guestItem) {
                $existingItem = $userCart->items()
                                       ->where('product_id', $guestItem->product_id)
                                       ->first();

                if ($existingItem) {
                    // Cập nhật quantity nếu sản phẩm đã tồn tại
                    $existingItem->quantity += $guestItem->quantity;
                    $existingItem->line_total = $existingItem->quantity * $existingItem->unit_price;
                    $existingItem->save();
                } else {
                    // Chuyển item sang user cart
                    $guestItem->update(['cart_id' => $userCart->id]);
                }
            }

            // Xóa guest cart
            $guestCart->delete();

            // Cập nhật totals
            $userCart->updateTotals();
        } else {
            // Chuyển guest cart thành user cart
            $guestCart->update([
                'user_id' => $userId,
                'session_id' => null,
            ]);
        }
    }

    // ===== EVENTS =====

    /**
     * Boot method - xử lý events
     */
    protected static function boot()
    {
        parent::boot();

        // Khi xóa cart → xóa tất cả items
        static::deleting(function ($cart) {
            $cart->items()->delete();
        });
    }
}




/*
===== CÁCH SỬ DỤNG MODELS =====

1. TẠO HOẶC LẤY CART:
$cart = Cart::getOrCreateForCurrentUser();

2. THÊM SẢN PHẨM VÀO CART:
$product = Product::find(1);
$cartItem = $cart->items()->create([
    'product_id' => $product->id,
    'quantity' => 2,
    'unit_price' => $product->price,
]);

3. CẬP NHẬT SỐ LƯỢNG:
$cartItem->updateQuantity(5);

4. XÓA ITEM:
$cartItem->delete();

5. XÓA TẤT CẢ ITEMS:
$cart->clearItems();

6. MERGE CART KHI LOGIN:
Cart::mergeGuestCartToUser(Auth::id());

7. LẤY CART VỚI ITEMS:
$cart = Cart::with('items.product')->forCurrentUser()->first();

8. TÌM CART ABANDONED:
$abandonedCarts = Cart::abandoned(7)->get(); // > 7 ngày
*/
