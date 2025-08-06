<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ShippingRate;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
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
    /**
 * Xử lý đặt hàng - Chuyển cart data sang order
 */
public function store(Request $request)
{
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'nullable|email|max:255',
        'customer_phone' => 'nullable|string|max:20',
        'province' => 'required|string',
        'city' => 'nullable|string',
        'address' => 'nullable|string|max:500',
        'delivery_time' => 'required|string',
        'payment_method_id' => 'required|exists:payment_methods,id',
        'subtotal' => 'required|numeric|min:0',
        'order_notes' => 'nullable|string|max:1000',
    ]);

    try {
        DB::beginTransaction();

        // 1. Lấy cart hiện tại
        $cart = $this->findBestCart();
        $cart->load(['items.product.category', 'items.product.unit']);

        if ($cart->total_item == 0) {
            throw new \Exception('Giỏ hàng trống');
        }

        // 2. Tính shipping fee từ province/city
        $shippingResult = ShippingRate::calculateShippingFee(
            $request->province,
            $request->city
        );

        if (!$shippingResult['success']) {
            throw new \Exception($shippingResult['message']);
        }

        // 3. Lấy payment method và shipping rate
        $paymentMethod = PaymentMethods::find($request->payment_method_id);
        $shippingRate = ShippingRate::where('province', $request->province)
                                  ->where(function($q) use ($request) {
                                      $q->where('city', $request->city)->orWhereNull('city');
                                  })
                                  ->orderByRaw('city IS NULL ASC')
                                  ->first();

        // 4. Tính totals (dùng subtotal từ form)
        $subtotal = $request->subtotal;
        $shippingFee = $shippingResult['fee'];
        $processingFee = $paymentMethod->calculateProcessingFee($subtotal);
        $totalAmount = $subtotal + $shippingFee + $processingFee;

        // 5. Tạo order number
        $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // 6. Tạo Order
        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => Auth::id(),
            'payment_method_id' => $paymentMethod->id,
            'shipping_rate_id' => $shippingRate ? $shippingRate->id : null,

            // Customer info
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,

            // Delivery info
            'delivery_province' => $request->province,
            'delivery_city' => $request->city,
            'delivery_address' => $request->address,
            'delivery_time_frame' => $request->delivery_time,

            // Pricing
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'shipping_zone_name' => $shippingResult['zone_name'],
            'processing_fee' => $processingFee,
            'discount_amount' => 0,
            'total_amount' => $totalAmount,

            // Status
            'status' => 'pending',
            'payment_status' => 'pending',
            'is_guest_order' => !Auth::check(),

            // Notes
            'order_notes' => $request->order_notes,
        ]);

        // 7. Chuyển cart items sang order items
        foreach ($cart->items as $cartItem) {
            $product = $cartItem->product;

            if (!$product) {
                Log::warning('Product not found for cart item', [
                    'cart_item_id' => $cartItem->id,
                    'product_id' => $cartItem->product_id,
                ]);
                throw new \Exception('Sản phẩm trong giỏ hàng không tồn tại');
            }

            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'product_name' => $product->name,
                'product_jp_name' => $product->jp_name ?? '',
                'product_slug' => $product->slug,
                'product_image' => $product->image ?? '',
                'unit_price' => $cartItem->unit_price,
                'quantity' => $cartItem->quantity,
                'line_total' => $cartItem->line_total,
                'discount_percent' => 0,
                'discount_amount' => 0,
                'product_weight' => $product->weight_per_unit ?? 0,
                'product_category' => $product->category->name ?? 'N/A',
                'product_unit' => $product->unit->name ?? 'N/A',
                'product_unit_display' => $product->unit->symbol ?? '',
            ]);
        }

        // 8. XÓA CART SAU KHI TẠO ORDER THÀNH CÔNG
        $cart->clearItems();
        $cart->delete();

        DB::commit();

        Log::info('ORDER CREATED SUCCESSFULLY', [
            'order_id' => $order->id,
            'order_number' => $orderNumber,
            'cart_id_deleted' => $cart->id,
            'total_amount' => $totalAmount,
        ]);

        // Redirect về homepage với thông báo thành công
        return redirect()->route('homepage')->with('success',
            'Đặt hàng thành công! Mã đơn hàng: ' . $orderNumber . '. Chúng tôi sẽ liên hệ với bạn sớm nhất.'
        );

    } catch (\Exception $e) {
        DB::rollback();

        Log::error('ORDER CREATION FAILED', [
            'error' => $e->getMessage(),
            'request_data' => $request->all(),
        ]);

        return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                               ->withInput();
    }
}
}
