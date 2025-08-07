<?php

// ===== FIX NHANH - FORCE CÙNG 1 CART =====
// app/Http/Controllers/Web/CartController.php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * FORCE DÙNG CART CÓ ITEMS NHIỀU NHẤT
     */
    public function index()
    {
        $cart = $this->findBestCart();

        Log::info('WEB CART FINAL', [
            'cart_found' => $cart ? 'YES' : 'NO',
            'cart_id' => $cart ? $cart->id : null,
            'items_count' => $cart ? $cart->items->count() : 0,
            'strategy' => 'BEST_CART'
        ]);

        return view('src.web.cart.index', [
            'cart' => $cart,
            'items' => $cart ? $cart->items : collect(),
            'subtotal' => $cart ? $cart->subtotal : 0,
            'totalItems' => $cart ? $cart->total_item : 0,
            'isEmpty' => !$cart || $cart->items->count() === 0
        ]);
    }

    // Rest of methods stay the same
    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        try {
            $cartItem = CartItem::findOrFail($itemId);
            $cartItem->updateQuantity($request->quantity);

            return redirect()->route('cart.index')->with('success', 'Đã cập nhật số lượng sản phẩm');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function removeItem($itemId)
    {
        try {
            $cartItem = CartItem::findOrFail($itemId);
            $cartItem->delete();

            return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function clear()
    {
        try {
            $cart = $this->findBestCart();

            if ($cart) {
                $cart->clearItems();
            }

            return redirect()->route('cart.index')->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function checkout()
    {
        $cart = $this->findBestCart();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        return view('web.checkout.index', compact('cart'));
    }

    // ===== LOGIC TÌM CART TỐT NHẤT =====

    /**
     * Tìm cart có items nhiều nhất trong 4 giờ gần đây
     */
    private function findBestCart()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        // Tìm TẤT CẢ cart active gần đây và sắp xếp theo độ ưu tiên
        $carts = Cart::where('status', 'active')
                    ->where('created_at', '>=', now()->subHours(4))
                    ->with(['items.product'])
                    ->withCount('items') // Count items
                    ->orderByDesc('items_count') // Cart có nhiều items nhất
                    ->orderByDesc('updated_at')  // Mới nhất
                    ->get();

        Log::info('ALL ACTIVE CARTS', [
            'total_carts' => $carts->count(),
            'carts_info' => $carts->map(fn($c) => [
                'id' => $c->id,
                'items_count' => $c->items_count,
                'user_id' => $c->user_id,
                'session_id' => substr($c->session_id, 0, 10) . '...',
                'updated_at' => $c->updated_at->format('H:i:s')
            ])
        ]);

        // Lấy cart tốt nhất (có items nhiều nhất)
        $bestCart = $carts->first();

        if ($bestCart) {
            // Sync session để maintain ownership
            $bestCart->update([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'updated_at' => now()
            ]);

            Log::info('BEST CART SELECTED', [
                'cart_id' => $bestCart->id,
                'items_count' => $bestCart->items_count,
                'synced_session' => $sessionId
            ]);
        }

        return $bestCart;
    }
}


// ===== TEST NHANH - DÙNG CART ID CỐ ĐỊNH =====
// Nếu muốn test nhanh, force dùng cart ID 10:

class CartControllerTest extends Controller
{
    public function index()
    {
        $cart = Cart::with(['items.product'])->find(10); // Force cart ID 10

        return view('src.web.cart.index', [
            'cart' => $cart,
            'items' => $cart ? $cart->items : collect(),
            'subtotal' => $cart ? $cart->subtotal : 0,
            'totalItems' => $cart ? $cart->total_item : 0,
            'isEmpty' => !$cart || $cart->items->count() === 0
        ]);
    }
}

/*
===== STRATEGY MỚI =====

1. Tìm TẤT CẢ cart active trong 4h
2. Sắp xếp theo:
   - items_count DESC (nhiều items nhất)
   - updated_at DESC (mới nhất)
3. Lấy cart đầu tiên (tốt nhất)
4. Sync session cho cart đó
5. API và Web đều dùng logic này

=> Đảm bảo cùng 1 cart!
*/
