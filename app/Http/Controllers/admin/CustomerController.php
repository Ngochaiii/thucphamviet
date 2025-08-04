<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Hiển thị danh sách khách hàng từ orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['orderItems', 'paymentMethods', 'user'])
                     ->orderBy('created_at', 'desc');

        // Lọc theo trạng thái nếu có
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Tìm kiếm theo tên hoặc email khách hàng
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$search}%")
                  ->orWhere('order_number', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        // Thống kê nhanh
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('src.admin.customers.index', compact('orders', 'stats'));
    }

    /**
     * Xem chi tiết đơn hàng của khách hàng
     */
    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'paymentMethods', 'shippingRate', 'user'])
                     ->findOrFail($id);

        return view('src.admin.customers.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipping,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;

        // Cập nhật trạng thái
        $order->update(['status' => $request->status]);

        // Cập nhật timestamp tương ứng
        switch ($request->status) {
            case 'confirmed':
                $order->update(['confirmed_at' => now()]);
                break;
            case 'shipping':
                $order->update(['shipped_at' => now()]);
                break;
            case 'delivered':
                $order->update(['delivered_at' => now()]);
                break;
        }

        return redirect()->route('admin.customers.index')
                       ->with('success', "Đã cập nhật trạng thái đơn #{$order->order_number} từ '{$oldStatus}' thành '{$request->status}'");
    }

    /**
     * Xác nhận đơn hàng (chuyển từ pending sang confirmed)
     */
    public function confirm($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->route('admin.customers.index')
                           ->with('error', 'Chỉ có thể xác nhận đơn hàng đang ở trạng thái chờ xử lý');
        }

        $order->update([
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);

        return redirect()->route('admin.customers.index')
                       ->with('success', "Đã xác nhận đơn hàng #{$order->order_number}");
    }

    /**
     * Hủy đơn hàng
     */
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if (in_array($order->status, ['delivered', 'cancelled'])) {
            return redirect()->route('admin.customers.index')
                           ->with('error', 'Không thể hủy đơn hàng đã giao hoặc đã hủy');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('admin.customers.index')
                       ->with('success', "Đã hủy đơn hàng #{$order->order_number}");
    }

    /**
     * Lấy label cho trạng thái
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy'
        ];

        return $labels[$status] ?? $status;
    }
}

