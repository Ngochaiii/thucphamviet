@extends('layouts.admin.index')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Thông báo -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <!-- Thống kê nhanh -->
            <div class="row mb-3">
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $stats['total'] }}</h3>
                            <p>Tổng đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $stats['pending'] }}</h3>
                            <p>Chờ xử lý</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $stats['confirmed'] }}</h3>
                            <p>Đã xác nhận</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $stats['delivered'] }}</h3>
                            <p>Đã giao</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $stats['cancelled'] }}</h3>
                            <p>Đã hủy</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách đơn hàng -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quản lý đơn hàng khách hàng</h3>
                    <div class="card-tools">
                        <!-- Tìm kiếm và lọc -->
                        <form method="GET" class="form-inline float-right">
                            <div class="input-group input-group-sm mr-2">
                                <select name="status" class="form-control">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý
                                    </option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã
                                        xác nhận</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                        Đang xử lý</option>
                                    <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang
                                        giao</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã
                                        giao</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã
                                        hủy</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mr-2">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..."
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm ml-1">
                                <i class="fas fa-refresh"></i>
                            </a>
                        </form>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Địa chỉ giao hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <strong>{{ $order->order_number }}</strong>
                                        @if ($order->is_guest_order)
                                            <br><span class="badge badge-secondary badge-sm">Khách vãng lai</span>
                                        @endif
                                        @if ($order->order_notes)
                                            <br><small class="text-info"><i class="fas fa-comment"></i> Có ghi chú</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->customer_name }}</strong>
                                            @if ($order->customer_email)
                                                <br><small><i class="fas fa-envelope text-muted"></i>
                                                    {{ $order->customer_email }}</small>
                                            @endif
                                            @if ($order->customer_phone)
                                                <br><small><i class="fas fa-phone text-muted"></i>
                                                    {{ $order->customer_phone }}</small>
                                            @endif
                                            @if ($order->user)
                                                <br><small class="text-muted">ID: {{ $order->user->id }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="max-width: 250px;">
                                        <div class="order-items">
                                            @foreach ($order->orderItems->take(3) as $item)
                                                <div class="d-flex align-items-center mb-1">
                                                    @if ($item->product_image)
                                                        <img src="{{ asset('storage/'. $item->product_image) }}"
                                                            alt="{{ $item->product_name }}" class="img-thumbnail mr-2"
                                                            style="width: 30px; height: 30px;">
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <small><strong>{{ Str::limit($item->product_name, 20) }}</strong></small>
                                                        @if ($item->product_jp_name)
                                                            <br><small
                                                                class="text-muted">{{ Str::limit($item->product_jp_name, 20) }}</small>
                                                        @endif
                                                        <br><small
                                                            class="text-success">¥{{ number_format($item->unit_price) }}</small>
                                                        @if ($item->product_category)
                                                            <span
                                                                class="badge badge-light badge-sm">{{ $item->product_category }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if ($order->orderItems->count() > 3)
                                                <small class="text-muted">... và {{ $order->orderItems->count() - 3 }} sản
                                                    phẩm khác</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="quantity-summary">
                                            @foreach ($order->orderItems->take(3) as $item)
                                                <div class="mb-1">
                                                    <span class="badge badge-primary">{{ $item->quantity }}</span>
                                                    @if ($item->product_unit_display)
                                                        <small class="text-muted">{{ $item->product_unit_display }}</small>
                                                    @endif
                                                </div>
                                            @endforeach
                                            @if ($order->orderItems->count() > 3)
                                                <small class="text-muted">...</small>
                                            @endif
                                            <hr class="my-1">
                                            <div class="text-center">
                                                <strong
                                                    class="text-info">{{ $order->orderItems->sum('quantity') }}</strong>
                                                <br><small class="text-muted">tổng items</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="max-width: 200px;">
                                        <div class="text-sm">
                                            <strong>{{ $order->delivery_province }}</strong>
                                            @if ($order->delivery_city)
                                                , {{ $order->delivery_city }}
                                            @endif
                                            @if ($order->delivery_address)
                                                <br><small
                                                    class="text-muted">{{ Str::limit($order->delivery_address, 40) }}</small>
                                            @endif
                                            @if ($order->delivery_time_frame)
                                                <br><small class="text-primary"><i class="fas fa-clock"></i>
                                                    {{ $order->delivery_time_frame }}</small>
                                            @endif
                                            @if ($order->shipping_zone_name)
                                                <br><small class="text-info">Vùng:
                                                    {{ $order->shipping_zone_name }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong class="text-success">¥
                                                {{ number_format($order->total_amount) }}</strong>
                                        </div>
                                        <small class="text-muted">
                                            Tạm tính: ¥{{ number_format($order->subtotal) }}
                                            @if ($order->shipping_fee > 0)
                                                <br>Ship: ¥{{ number_format($order->shipping_fee) }}
                                            @endif
                                            @if ($order->processing_fee > 0)
                                                <br>Phí XL: ¥{{ number_format($order->processing_fee) }}
                                            @endif
                                            @if ($order->discount_amount > 0)
                                                <br>Giảm: -¥{{ number_format($order->discount_amount) }}
                                            @endif
                                        </small>
                                        <br><span
                                            class="badge {{ $order->payment_status == 'pending'
                                                ? 'badge-warning'
                                                : ($order->payment_status == 'paid'
                                                    ? 'badge-success'
                                                    : ($order->payment_status == 'failed'
                                                        ? 'badge-danger'
                                                        : 'badge-info')) }} badge-sm">
                                            {{ $order->payment_status == 'pending'
                                                ? 'Chờ TT'
                                                : ($order->payment_status == 'paid'
                                                    ? 'Đã TT'
                                                    : ($order->payment_status == 'failed'
                                                        ? 'TT thất bại'
                                                        : 'Hoàn tiền')) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $order->status == 'pending'
                                                ? 'badge-warning'
                                                : ($order->status == 'confirmed'
                                                    ? 'badge-success'
                                                    : ($order->status == 'processing'
                                                        ? 'badge-info'
                                                        : ($order->status == 'shipping'
                                                            ? 'badge-primary'
                                                            : ($order->status == 'delivered'
                                                                ? 'badge-success'
                                                                : 'badge-danger')))) }}"
                                            id="status-{{ $order->id }}">
                                            {{ $order->status == 'pending'
                                                ? 'Chờ xử lý'
                                                : ($order->status == 'confirmed'
                                                    ? 'Đã xác nhận'
                                                    : ($order->status == 'processing'
                                                        ? 'Đang xử lý'
                                                        : ($order->status == 'shipping'
                                                            ? 'Đang giao'
                                                            : ($order->status == 'delivered'
                                                                ? 'Đã giao'
                                                                : 'Đã hủy')))) }}
                                        </span>
                                        @if ($order->confirmed_at)
                                            <br><small class="text-muted">XN:
                                                {{ $order->confirmed_at->format('d/m H:i') }}</small>
                                        @endif
                                        @if ($order->shipped_at)
                                            <br><small class="text-muted">Giao:
                                                {{ $order->shipped_at->format('d/m H:i') }}</small>
                                        @endif
                                        @if ($order->delivered_at)
                                            <br><small class="text-muted">Hoàn thành:
                                                {{ $order->delivered_at->format('d/m H:i') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                        @if ($order->paymentMethods)
                                            <br><small class="text-info">{{ $order->paymentMethods->name }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <!-- Nút xác nhận (chỉ hiện với đơn pending) -->
                                            @if ($order->status == 'pending')
                                                <form method="POST"
                                                    action="{{ route('admin.customers.confirm', $order->id) }}"
                                                    class="mb-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success btn-block"
                                                        onclick="return confirm('Xác nhận đơn hàng này?')"
                                                        title="Xác nhận">
                                                        <i class="fas fa-check"></i> Xác nhận
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Form thay đổi trạng thái -->
                                            <form method="POST"
                                                action="{{ route('admin.customers.update-status', $order->id) }}">
                                                @csrf
                                                <select name="status" class="form-control form-control-sm"
                                                    onchange="if(confirm('Thay đổi trạng thái?')) this.form.submit();">
                                                    <option value="">-- Đổi trạng thái --</option>
                                                    @if ($order->status != 'confirmed')
                                                        <option value="confirmed">✓ Xác nhận</option>
                                                    @endif
                                                    @if ($order->status != 'processing')
                                                        <option value="processing">⚙ Đang xử lý</option>
                                                    @endif
                                                    @if ($order->status != 'shipping')
                                                        <option value="shipping">🚚 Đang giao</option>
                                                    @endif
                                                    @if ($order->status != 'delivered')
                                                        <option value="delivered">✅ Đã giao</option>
                                                    @endif
                                                    @if (!in_array($order->status, ['delivered', 'cancelled']))
                                                        <option value="cancelled" style="color: red;">❌ Hủy đơn</option>
                                                    @endif
                                                </select>
                                            </form>

                                            <!-- Hiển thị ghi chú nếu có -->
                                            @if ($order->order_notes)
                                                <button type="button" class="btn btn-sm btn-outline-info mt-1"
                                                    data-toggle="collapse" data-target="#notes-{{ $order->id }}"
                                                    title="Xem ghi chú">
                                                    <i class="fas fa-comment"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @if ($order->order_notes)
                                    <tr class="collapse" id="notes-{{ $order->id }}">
                                        <td colspan="9" class="bg-light">
                                            <div class="p-2">
                                                <strong class="text-info">Ghi chú từ khách hàng:</strong>
                                                <div class="mt-1">{{ $order->order_notes }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                        <br>Không có đơn hàng nào
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('footer_js')
    <script>
        $(function() {
            // Auto-hide alerts sau 5 giây
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);

            // Tooltip cho các thông tin chi tiết
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
@push('css')
    <style>
        .order-items {
            max-height: 150px;
            overflow-y: auto;
        }

        .table td {
            vertical-align: top;
        }

        .btn-group-vertical .btn {
            margin-bottom: 2px;
        }
    </style>
@endpush
