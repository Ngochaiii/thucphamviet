@extends('layouts.web.index')

@section('content')
<!-- CSRF Token for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container py-4">
    <!-- Form bao bọc toàn bộ checkout -->
    <form id="checkout-form" method="POST" action="{{ route('order.store') }}">
        @csrf

        <!-- Hidden inputs chứa order data -->
        <input type="hidden" name="subtotal" value="{{ $orderSummary['subtotal'] }}">
        <input type="hidden" name="payment_method_id" value="{{ $paymentMethods->first()->id }}">

        <div class="row">
        <!-- Billing Details Section -->
        <div class="col-lg-7 col-md-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4 fw-bold">BILLING DETAILS</h4>

                    <form id="checkout-form" method="POST" action="{{ route('order.store') }}">
                        @csrf
                        <!-- Họ và tên -->
                        <div class="mb-3">
                            <label for="customer_name" class="form-label fw-semibold">
                                Họ và tên <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg" id="customer_name" name="customer_name" required>
                        </div>

                        <!-- Tỉnh/Thành phố -->
                        <div class="mb-3">
                            <label for="province" class="form-label fw-semibold">
                                Tỉnh/Thành phố <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg" id="province" name="province" required>
                                <option value="">Chọn tỉnh/thành phố</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province }}">{{ $province }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quận/Huyện -->
                        <div class="mb-3" id="city-container">
                            <label for="city" class="form-label fw-semibold">
                                Quận/Huyện
                            </label>
                            <input class="form-control form-control-lg" id="city" name="city">
                            </input>
                        </div>

                        <!-- Địa chỉ -->
                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">
                                Địa chỉ (optional)
                            </label>
                            <input type="text" class="form-control form-control-lg" id="address" name="address"
                                   placeholder="Bạn có thể gửi địa chỉ qua tin nhắn FB">
                        </div>

                        <!-- Khung giờ nhận hàng -->
                        <div class="mb-4">
                            <label for="delivery_time" class="form-label fw-semibold">
                                Khung giờ nhận hàng <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg" id="delivery_time" name="delivery_time" required>
                                <option value="">Chọn khung giờ nhận hàng</option>
                                @foreach($deliveryTimeFrames as $value => $display)
                                    <option value="{{ $value }}">{{ $display }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Additional Information -->
                        <h5 class="mb-3 fw-bold">ADDITIONAL INFORMATION</h5>

                        <div class="mb-3">
                            <label for="order_notes" class="form-label fw-semibold">
                                Order Notes (optional)
                            </label>
                            <textarea class="form-control" id="order_notes" name="order_notes" rows="4"
                                      placeholder="Ghi chú khác nếu có: phương thức thanh toán, ngày nhận, yêu cầu cụ thể khác..."></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary Section -->
        <div class="col-lg-5 col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4 fw-bold">YOUR ORDER</h4>

                    <!-- Product Header -->
                    <div class="row border-bottom pb-2 mb-3">
                        <div class="col-8">
                            <span class="fw-semibold">PRODUCT</span>
                        </div>
                        <div class="col-4 text-end">
                            <span class="fw-semibold">SUBTOTAL</span>
                        </div>
                    </div>

                    @if($cart->items->count() > 0)
                        <!-- Product Items -->
                        @foreach($cart->items as $item)
                        <div class="row align-items-center py-2 border-bottom">
                            <div class="col-8">
                                <div class="product-info">
                                    <span class="product-name">
                                        {{ $item->product->name }}
                                        @if($item->product->jp_name)
                                            | {{ $item->product->jp_name }}
                                        @endif
                                    </span>
                                    <span class="text-muted ms-2">× {{ $item->quantity }}</span>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <span class="text-danger fw-bold">¥ {{ number_format($item->line_total) }}</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="row py-3">
                            <div class="col-12 text-center text-muted">
                                <p>Giỏ hàng của bạn đang trống</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                            </div>
                        </div>
                    @endif

                    <!-- Subtotal -->
                    <div class="row py-2 border-bottom">
                        <div class="col-8">
                            <span class="fw-semibold">Subtotal</span>
                        </div>
                        <div class="col-4 text-end">
                            <span class="text-danger fw-bold" id="subtotal">{{ $orderSummary['formatted_subtotal'] }}</span>
                        </div>
                    </div>

                    <!-- Shipping -->
                    <div class="row py-2 border-bottom">
                        <div class="col-8">
                            <span class="fw-semibold">Phí vận chuyển</span>
                            <small class="text-muted d-block" id="shipping-info"></small>
                        </div>
                        <div class="col-4 text-end">
                            <span class="text-danger fw-bold" id="shipping-fee">{{ $orderSummary['formatted_shipping_fee'] }}</span>
                        </div>
                    </div>

                    <!-- Processing Fee (nếu có) -->
                    @if($orderSummary['processing_fee'] > 0)
                    <div class="row py-2 border-bottom">
                        <div class="col-8">
                            <span class="fw-semibold">Phí xử lý</span>
                        </div>
                        <div class="col-4 text-end">
                            <span class="text-danger fw-bold" id="processing-fee">{{ $orderSummary['formatted_processing_fee'] }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Total -->
                    <div class="row py-3 border-bottom">
                        <div class="col-8">
                            <span class="fw-bold fs-5">Total</span>
                        </div>
                        <div class="col-4 text-end">
                            <span class="text-danger fw-bold fs-5" id="total-amount">{{ $orderSummary['formatted_total'] }}</span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mt-4">
                        <label class="form-label fw-semibold mb-3">Phương thức thanh toán</label>
                        <select class="form-select form-select-lg" id="payment_method" name="payment_method_id">
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}" {{ $loop->first ? 'selected' : '' }}>
                                    {{ $method->name }} - {{ $method->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Privacy Notice -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">
                            Thông tin cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, tăng trải nghiệm sử dụng
                            website, và cho các mục đích cụ thể khác đã được mô tả trong
                            <a href="#" class="text-decoration-none">privacy policy</a>.
                        </small>
                    </div>

                    <!-- Place Order Button -->
                    <div class="mt-4 d-grid">
                        <button type="submit" class="btn btn-danger btn-lg py-3 fw-bold" style="background-color: #B73E3E;">
                            PLACE ORDER
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Custom CSS -->
<style>
.card {
    border-radius: 8px;
}

.form-select:focus {
    border-color: #B73E3E;
    box-shadow: 0 0 0 0.2rem rgba(183, 62, 62, 0.25);
}

.form-control:focus {
    border-color: #B73E3E;
    box-shadow: 0 0 0 0.2rem rgba(183, 62, 62, 0.25);
}

.text-danger {
    color: #B73E3E !important;
}

.btn-danger {
    background-color: #B73E3E;
    border-color: #B73E3E;
}

.btn-danger:hover {
    background-color: #9d3434;
    border-color: #9d3434;
}

.product-name {
    font-size: 0.9rem;
    line-height: 1.4;
}

.border-bottom {
    border-color: #dee2e6 !important;
}

.form-check-input:checked {
    background-color: #B73E3E;
    border-color: #B73E3E;
}

.card-title {
    color: #333;
    letter-spacing: 0.5px;
}

.btn-outline-secondary {
    border-color: #dee2e6;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
}

@media (max-width: 768px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .product-name {
        font-size: 0.8rem;
    }
}
</style>

<!-- JavaScript for form interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province');
    const cityInput = document.getElementById('city');
    const shippingFeeElement = document.getElementById('shipping-fee');
    const shippingInfoElement = document.getElementById('shipping-info');
    const totalAmountElement = document.getElementById('total-amount');

    // Lấy subtotal có sẵn từ server (đã có khi load page)
    const subtotal = {{ $orderSummary['subtotal'] }};
    const processingFee = {{ $orderSummary['processing_fee'] }};

    console.log('Page loaded with subtotal:', subtotal, 'processing fee:', processingFee);

    // Function to calculate shipping
    function calculateShipping() {
        const province = provinceSelect.value;
        const city = cityInput.value;

        if (!province) {
            shippingFeeElement.textContent = 'Chọn địa chỉ';
            shippingInfoElement.textContent = '';
            updateTotal(0); // No shipping fee
            return;
        }

        // Show loading
        shippingFeeElement.textContent = 'Đang tính...';
        shippingInfoElement.textContent = '';

        // AJAX call to get ONLY shipping fee
        fetch('/api/checkout/calculate-shipping', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ province, city })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Shipping API Response:', data);

            if (data.success) {
                const shippingFee = parseFloat(data.shipping_fee) || 0;

                // Update UI elements safely
                if (shippingFeeElement) {
                    shippingFeeElement.textContent = data.formatted_shipping_fee;
                }

                if (shippingInfoElement && data.zone_name && data.delivery_days) {
                    shippingInfoElement.textContent = `${data.zone_name} - ${data.delivery_days} ngày`;
                }

                // Tính total = subtotal + shipping + processing fee
                updateTotal(shippingFee);

                console.log('Updated shipping fee:', shippingFee);
            } else {
                if (shippingFeeElement) {
                    shippingFeeElement.textContent = 'Không hỗ trợ';
                }
                if (shippingInfoElement) {
                    shippingInfoElement.textContent = data.message || 'Không hỗ trợ giao hàng đến khu vực này';
                }
                updateTotal(0);
            }
        })
        .catch(error => {
            console.error('Shipping calculation error:', error);

            if (shippingFeeElement) {
                shippingFeeElement.textContent = 'Lỗi tính phí';
            }
            if (shippingInfoElement) {
                shippingInfoElement.textContent = 'Lỗi khi tính phí ship';
            }
            updateTotal(0);
        });
    }

    // Function to update total based on shipping fee
    function updateTotal(shippingFee) {
        const total = subtotal + shippingFee + processingFee;

        if (totalAmountElement) {
            totalAmountElement.textContent = `¥ ${total.toLocaleString()}`;
        }

        console.log('Total calculation:', {
            subtotal: subtotal,
            shippingFee: shippingFee,
            processingFee: processingFee,
            total: total
        });
    }

    // Event listeners - CHỈ CHO SHIPPING CALCULATION
    provinceSelect.addEventListener('change', calculateShipping);
    cityInput.addEventListener('blur', calculateShipping);

    // KHÔNG CÓ FORM SUBMISSION HANDLER - ĐỂ BROWSER XỬ LÝ TỰ NHIÊN
});
</script>
@endsection
