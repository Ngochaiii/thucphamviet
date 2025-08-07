<?php

// ===== FIX 1: CẬP NHẬT CARTCONTROLLER =====
// app/Http/Controllers/Api/CartController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Lấy thông tin giỏ hàng - FIX SESSION ISSUE
     */
    // Cập nhật method getCart() để dùng logic tương tự:

    public function getCart(): JsonResponse
    {
        try {
            $cart = $this->findBestCartAPI();

            if (!$cart) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'cart' => null,
                        'items' => [],
                        'totals' => [
                            'subtotal' => 0,
                            'total_items' => 0,
                            'formatted_subtotal' => '¥ 0'
                        ]
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'cart' => $this->formatCartResponse($cart),
                    'items' => $cart->items->map(fn($item) => $this->formatCartItemResponse($item)),
                    'totals' => [
                        'subtotal' => $cart->subtotal,
                        'total_items' => $cart->total_item,
                        'formatted_subtotal' => '¥ ' . number_format($cart->subtotal, 0)
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    private function findBestCartAPI()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        $carts = Cart::where('status', 'active')
            ->where('created_at', '>=', now()->subHours(4))
            ->with(['items.product'])
            ->withCount('items')
            ->orderByDesc('items_count')
            ->orderByDesc('updated_at')
            ->get();

        $bestCart = $carts->first();

        if ($bestCart) {
            $bestCart->update([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'updated_at' => now()
            ]);

            Log::info('API BEST CART SELECTED', [
                'cart_id' => $bestCart->id,
                'items_count' => $bestCart->items_count
            ]);
        }

        return $bestCart;
    }
    private function getOrCreateCartFixed(): Cart
    {
        // Tìm cart tốt nhất trước
        $cart = $this->findBestCartAPI();

        if (!$cart) {
            // Tạo mới nếu không tìm thấy
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::id() ? null : Session::getId(),
                'subtotal' => 0,
                'total_item' => 0,
                'status' => 'active'
            ]);
        }

        return $cart;
    }
    /**
     * Thêm sản phẩm vào giỏ hàng - FIX SESSION ISSUE
     */
    public function addToCart(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1|max:99',
            ]);

            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);

            // Lấy hoặc tạo cart với logic mới
            $cart = $this->getOrCreateCartFixed();

            // Kiểm tra item đã tồn tại chưa
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->line_total = $cartItem->quantity * $cartItem->unit_price;
                $cartItem->save();
            } else {
                $cartItem = CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'unit_price' => $product->is_discounted ? $product->discounted_price : $product->price,
                    'line_total' => $request->quantity * ($product->is_discounted ? $product->discounted_price : $product->price),
                ]);
            }

            // Load cart với relationships
            $cart->load(['items.product']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng thành công!',
                'data' => [
                    'cart' => $this->formatCartResponse($cart),
                    'items' => $cart->items->map(fn($item) => $this->formatCartItemResponse($item)),
                    'totals' => [
                        'subtotal' => $cart->subtotal,
                        'total_items' => $cart->total_item,
                        'formatted_subtotal' => '¥ ' . number_format($cart->subtotal, 0)
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function updateQuantity(Request $request, $itemId): JsonResponse
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:99'
            ]);

            DB::beginTransaction();

            $cartItem = CartItem::findOrFail($itemId);
            $cartItem->updateQuantity($request->quantity);
            $cart = $cartItem->cart->fresh(['items.product']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật số lượng',
                'data' => [
                    'item' => $this->formatCartItemResponse($cartItem),
                    'totals' => [
                        'subtotal' => $cart->subtotal,
                        'total_items' => $cart->total_item,
                        'formatted_subtotal' => '¥ ' . number_format($cart->subtotal, 0)
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeItem($itemId): JsonResponse
    {
        try {
            DB::beginTransaction();

            $cartItem = CartItem::findOrFail($itemId);
            $cart = $cartItem->cart;
            $cartItem->delete();
            $cart = $cart->fresh(['items.product']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                'data' => [
                    'totals' => [
                        'subtotal' => $cart->subtotal,
                        'total_items' => $cart->total_item,
                        'formatted_subtotal' => '¥ ' . number_format($cart->subtotal, 0)
                    ],
                    'is_empty' => $cart->isEmpty()
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    // ===== PRIVATE METHODS - FIXED =====

    private function formatCartResponse(Cart $cart): array
    {
        return [
            'id' => $cart->id,
            'user_id' => $cart->user_id,
            'session_id' => $cart->session_id,
            'subtotal' => $cart->subtotal,
            'total_item' => $cart->total_item,
            'status' => $cart->status,
            'created_at' => $cart->created_at->toISOString(),
            'updated_at' => $cart->updated_at->toISOString(),
        ];
    }

    private function formatCartItemResponse(CartItem $cartItem): array
    {
        return [
            'id' => $cartItem->id,
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'unit_price' => $cartItem->unit_price,
            'line_total' => $cartItem->line_total,
            'formatted_unit_price' => '¥ ' . number_format($cartItem->unit_price, 0),
            'formatted_line_total' => '¥ ' . number_format($cartItem->line_total, 0),
            'product' => [
                'id' => $cartItem->product->id,
                'name' => $cartItem->product->name,
                'jp_name' => $cartItem->product->jp_name ?? '',
                'image' => $cartItem->product->image,
                'price' => $cartItem->product->price,
                'currency' => $cartItem->product->currency ?? 'JPY',
            ]
        ];
    }
}

// ===== FIX 2: SESSION CONFIG =====
// config/session.php - Đảm bảo session stable

/*
return [
    'driver' => env('SESSION_DRIVER', 'file'),
    'lifetime' => env('SESSION_LIFETIME', 120),
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => storage_path('framework/sessions'),
    'connection' => env('SESSION_CONNECTION'),
    'table' => 'sessions',
    'store' => env('SESSION_STORE'),
    'lottery' => [2, 100],
    'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'laravel'), '_').'_session'),
    'path' => '/',
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIE'),
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
];
*/

// ===== FIX 3: MIDDLEWARE EXEMPT =====
// app/Http/Kernel.php - Exempt cart API from CSRF if needed

/*
protected $except = [
    'api/cart/*',
];
*/
