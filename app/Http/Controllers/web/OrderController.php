<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ShippingRate;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        // 1. Lấy cart hiện tại - dùng logic tương tự CartController
        $cart = $this->findBestCart();

        // Debug: Log cart information
        Log::info('CHECKOUT CART DEBUG', [
            'cart_id' => $cart->id,
            'cart_total_item' => $cart->total_item,
            'cart_subtotal' => $cart->subtotal,
            'items_count_direct' => $cart->items()->count(),
            'cart_isEmpty' => $cart->isEmpty(),
        ]);

        // 2. Load cart với items và product details TRƯỚC KHI kiểm tra isEmpty
        $cart->load(['items.product']);

        // Debug: Log sau khi load items
        Log::info('CHECKOUT CART AFTER LOAD', [
            'items_loaded_count' => $cart->items->count(),
            'items_collection' => $cart->items->pluck('id', 'quantity')->toArray(),
        ]);

        // Kiểm tra cart có sản phẩm không (sử dụng total_item thay vì isEmpty())
        if ($cart->total_item == 0) {
            Log::warning('CHECKOUT CART EMPTY REDIRECT', ['cart_id' => $cart->id]);
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // 3. Lấy danh sách tỉnh/thành phố từ ShippingRate
        $provinces = ShippingRate::getAvailableProvinces();

        // 4. Lấy payment methods từ database
        $paymentMethods = PaymentMethods::systemMethods()
                                       ->active()
                                       ->orderBy('sort_order')
                                       ->get();

        // 5. Khung giờ giao hàng
        $deliveryTimeFrames = [
            '9-12h' => '9:00 - 12:00',
            '12-15h' => '12:00 - 15:00',
            '15-18h' => '15:00 - 18:00',
            '18-21h' => '18:00 - 21:00',
        ];

        // 6. Tính toán order summary
        $subtotal = $cart->subtotal;
        $defaultShippingFee = 0; // Sẽ được tính động qua JavaScript
        $defaultPaymentMethod = $paymentMethods->first();
        $processingFee = $defaultPaymentMethod ? $defaultPaymentMethod->calculateProcessingFee($subtotal) : 0;
        $totalAmount = $subtotal + $defaultShippingFee + $processingFee;

        $orderSummary = [
            'subtotal' => $subtotal,
            'formatted_subtotal' => '¥ ' . number_format($subtotal),
            'shipping_fee' => $defaultShippingFee,
            'formatted_shipping_fee' => $defaultShippingFee > 0 ? '¥ ' . number_format($defaultShippingFee) : 'Chọn địa chỉ',
            'processing_fee' => $processingFee,
            'formatted_processing_fee' => '¥ ' . number_format($processingFee),
            'total_amount' => $totalAmount,
            'formatted_total' => '¥ ' . number_format($totalAmount),
        ];

        Log::info('CHECKOUT SUCCESS', [
            'cart_id' => $cart->id,
            'items_count' => $cart->items->count(),
            'order_summary' => $orderSummary,
        ]);

        return view('src.web.order.index', compact(
            'cart',
            'provinces',
            'paymentMethods',
            'deliveryTimeFrames',
            'orderSummary'
        ));
    }

    /**
     * Tìm cart tốt nhất - CÙNG LOGIC VỚI CartController
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

        Log::info('CHECKOUT ALL ACTIVE CARTS', [
            'total_carts' => $carts->count(),
            'carts_info' => $carts->map(fn($c) => [
                'id' => $c->id,
                'items_count' => $c->items_count,
                'user_id' => $c->user_id,
                'session_id' => substr($c->session_id ?? '', 0, 10) . '...',
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

            Log::info('CHECKOUT BEST CART SELECTED', [
                'cart_id' => $bestCart->id,
                'items_count' => $bestCart->items_count,
                'synced_session' => $sessionId
            ]);
        } else {
            // Tạo cart mới nếu không tìm thấy
            $bestCart = Cart::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'status' => 'active',
            ]);

            Log::info('CHECKOUT CREATED NEW CART', [
                'cart_id' => $bestCart->id,
            ]);
        }

        return $bestCart;
    }

    /**
     * API: Tính phí ship theo địa điểm
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'province' => 'required|string',
            'city' => 'nullable|string',
        ]);

        $result = ShippingRate::calculateShippingFee(
            $request->province,
            $request->city
        );

        if ($result['success']) {
            // Lấy cart để tính total
            $cart = Cart::getOrCreateForCurrentUser();
            $subtotal = $cart->subtotal;
            $shippingFee = $result['fee'];

            // Lấy payment method đầu tiên (COD) để tính processing fee
            $paymentMethod = PaymentMethods::systemMethods()->active()->first();
            $processingFee = $paymentMethod ? $paymentMethod->calculateProcessingFee($subtotal) : 0;

            $total = $subtotal + $shippingFee + $processingFee;

            return response()->json([
                'success' => true,
                'shipping_fee' => $shippingFee,
                'formatted_shipping_fee' => '¥ ' . number_format($shippingFee),
                'total_amount' => $total,
                'formatted_total' => '¥ ' . number_format($total),
                'zone_name' => $result['zone_name'],
                'delivery_days' => $result['delivery_days']
            ]);
        }

        return response()->json($result);
    }
}
