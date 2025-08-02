{{-- resources/views/web/cart/index.blade.php - FIXED VERSION --}}

@extends('layouts.web.index')

@section('content')
{{-- Thêm Bootstrap Icons CDN nếu chưa có --}}
@push('header_css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
.cart-item:last-child {
    border-bottom: none !important;
}

.cart-item:hover {
    background-color: #f8f9fa;
}

.cart-item-image {
    transition: transform 0.3s ease;
}

.cart-item:hover .cart-item-image {
    transform: scale(1.05);
}

.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-input {
    -moz-appearance: textfield;
}

.quantity-btn {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    border: 1px solid #dee2e6;
    background: white;
    color: #495057;
}

.quantity-btn:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

.quantity-btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.delete-btn {
    width: 40px;
    height: 40px;
    background: #dc3545;
    border: none;
    color: white;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.delete-btn:hover {
    background: #c82333;
    transform: scale(1.05);
}

.product-price {
    font-size: 1.25rem;
    font-weight: bold;
    color: #dc3545;
}

@media (max-width: 768px) {
    .cart-item .row {
        align-items: center;
    }

    .quantity-form {
        justify-content: center;
        margin: 10px 0;
    }

    .quantity-btn {
        width: 35px;
        height: 35px;
        font-size: 16px;
    }

    .delete-btn {
        width: 35px;
        height: 35px;
    }
}
</style>
@endpush

<div class="container py-5">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="bi bi-cart3 me-2"></i>
                    Giỏ hàng của bạn
                </h1>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Tiếp tục mua hàng
                </a>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Main Content --}}
    @if($isEmpty)
        {{-- Empty Cart --}}
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-cart-x" style="font-size: 4rem; color: #dee2e6;"></i>
                    </div>
                    <h3 class="text-muted mb-3">Giỏ hàng trống</h3>
                    <p class="text-muted mb-4">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                    <a href="{{ route('homepage') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-shop me-2"></i>
                        Khám phá sản phẩm
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Cart Items --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Sản phẩm trong giỏ hàng ({{ $totalItems }})</h5>
                            <form action="{{ route('cart.clear') }}" method="POST"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash me-1"></i>
                                    Xóa tất cả
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @foreach($items as $item)
                            <div class="cart-item border-bottom" data-item-id="{{ $item->id }}">
                                <div class="row g-0 p-4">
                                    {{-- Product Image --}}
                                    <div class="col-md-2 col-3">
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                             alt="{{ $item->product->name }}"
                                             class="img-fluid rounded cart-item-image"
                                             style="width: 100%; height: 100px; object-fit: cover;">
                                    </div>

                                    {{-- Product Info --}}
                                    <div class="col-md-4 col-9">
                                        <div class="ps-3">
                                            <h5 class="fw-semibold mb-2">{{ $item->product->name }}</h5>
                                            @if($item->product->jp_name)
                                                <p class="text-muted mb-2">{{ $item->product->jp_name }}</p>
                                            @endif
                                            <div class="text-muted">
                                                Đơn giá: <span class="fw-medium text-dark">¥{{ number_format($item->unit_price,0) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Quantity Controls --}}
                                    <div class="col-md-3 col-6">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                                  class="quantity-form d-flex align-items-center">
                                                @csrf
                                                @method('PUT')

                                                <button type="button" class="btn quantity-btn rounded-start"
                                                        onclick="changeQuantity(this, -1)">
                                                    −
                                                </button>

                                                <input type="number" name="quantity"
                                                       value="{{ $item->quantity }}"
                                                       min="1" max="99"
                                                       class="form-control text-center quantity-input border-start-0 border-end-0"
                                                       style="width: 80px; border-radius: 0;"
                                                       onchange="this.form.submit()">

                                                <button type="button" class="btn quantity-btn rounded-end"
                                                        onclick="changeQuantity(this, 1)">
                                                    +
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Price & Delete --}}
                                    <div class="col-md-3 col-6">
                                        <div class="d-flex align-items-center justify-content-between h-100">
                                            <div class="text-center flex-grow-1">
                                                <div class="product-price">{{ $item->formatted_line_total }}</div>
                                            </div>
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                                                  class="ms-3">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn delete-btn" title="Xóa sản phẩm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-lg-4">
                <div class="card shadow-sm position-sticky" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-receipt me-2"></i>
                            Tóm tắt đơn hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Order Details --}}
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-medium">Số lượng sản phẩm:</span>
                            <span class="fw-bold">{{ $totalItems }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Tạm tính:</span>
                            <span>¥ {{ number_format($subtotal, 0) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success fw-medium">Tạm chưa tính </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Tổng cộng:</span>
                            <span class="h4 text-danger fw-bold">¥ {{ number_format($subtotal, 0) }}</span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-grid gap-3">
                            <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-credit-card me-2"></i>
                                Tiến hành thanh toán
                            </a>

                            <a href="{{ route('homepage') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Tiếp tục mua hàng
                            </a>
                        </div>

                        {{-- Additional Info --}}
                        <div class="mt-4 pt-4 border-top">
                            <div class="text-muted small">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-shield-check text-success me-2"></i>
                                    <span>Thanh toán an toàn</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-truck text-info me-2"></i>
                                    <span>Giao hàng nhanh chóng</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-arrow-return-left text-warning me-2"></i>
                                    <span>Đổi trả dễ dàng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Scripts --}}
@push('footer_js')
<script>
function changeQuantity(button, change) {
    const form = button.closest('.quantity-form');
    const input = form.querySelector('.quantity-input');
    const currentValue = parseInt(input.value) || 1;
    const newValue = Math.max(1, Math.min(99, currentValue + change));

    if (newValue !== currentValue) {
        input.value = newValue;

        // Add loading effect
        button.disabled = true;
        button.style.opacity = '0.6';

        // Submit form
        form.submit();
    }
}

// Auto-submit form when quantity input changes
document.querySelectorAll('.quantity-input').forEach(input => {
    let timeout;
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            if (this.value >= 1 && this.value <= 99) {
                this.form.submit();
            }
        }, 1000);
    });
});

// Add loading effect for delete buttons
document.querySelectorAll('form[method="POST"]').forEach(form => {
    form.addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
        }
    });
});

// Update cart modal nếu có
if (window.cartManager) {
    window.cartManager.loadCart();
}
</script>
@endpush
@endsection
