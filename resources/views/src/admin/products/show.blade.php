@extends('layouts.admin.index')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Breadcrumb -->
                <div class="card mb-3">
                    <div class="card-body">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
                            <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Thông tin cơ bản -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $product->name }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit mr-1"></i> Chỉnh sửa
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">ID:</dt>
                                    <dd class="col-sm-8">{{ $product->id }}</dd>

                                    <dt class="col-sm-4">Tên sản phẩm:</dt>
                                    <dd class="col-sm-8">{{ $product->name }}</dd>

                                    @if($product->jp_name)
                                    <dt class="col-sm-4">Tên tiếng Nhật:</dt>
                                    <dd class="col-sm-8">{{ $product->jp_name }}</dd>
                                    @endif

                                    <dt class="col-sm-4">Slug:</dt>
                                    <dd class="col-sm-8"><code>{{ $product->slug }}</code></dd>

                                    <dt class="col-sm-4">Danh mục:</dt>
                                    <dd class="col-sm-8">
                                        @if($product->category)
                                            <span class="badge badge-info">{{ $product->category->name }}</span>
                                        @else
                                            <span class="text-muted">Không có</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Đơn vị:</dt>
                                    <dd class="col-sm-8">
                                        @if($product->unit)
                                            <span class="badge badge-secondary">{{ $product->unit->name }}</span>
                                        @else
                                            <span class="text-muted">Không có</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">Giá bán:</dt>
                                    <dd class="col-sm-8">
                                        <span class="text-primary font-weight-bold">
                                            {{ \App\Helpers\CurrencyHelper::formatPrice($product->price, $product->currency ?? 'JPY') }}
                                        </span>
                                        <span class="badge badge-secondary ml-1">{{ $product->currency ?? 'JPY' }}</span>
                                    </dd>

                                    @if($product->discount > 0)
                                    <dt class="col-sm-4">Giảm giá:</dt>
                                    <dd class="col-sm-8">
                                        <span class="text-danger">{{ $product->discount }}%</span>
                                    </dd>

                                    <dt class="col-sm-4">Giá sau giảm:</dt>
                                    <dd class="col-sm-8">
                                        @php
                                            $discountedPrice = $product->price - ($product->price * $product->discount / 100);
                                        @endphp
                                        <span class="text-success font-weight-bold">
                                            {{ \App\Helpers\CurrencyHelper::formatPrice($discountedPrice, $product->currency ?? 'JPY') }}
                                        </span>
                                    </dd>
                                    @endif

                                    <dt class="col-sm-4">Số lượng:</dt>
                                    <dd class="col-sm-8">
                                        @php
                                            $isInStock = $product->quantity > 0;
                                        @endphp
                                        <span class="badge {{ $isInStock ? 'badge-success' : 'badge-danger' }}">
                                            {{ number_format($product->quantity) }}
                                            @if($isInStock)
                                                (Còn hàng)
                                            @else
                                                (Hết hàng)
                                            @endif
                                        </span>
                                    </dd>

                                    <dt class="col-sm-4">Trạng thái:</dt>
                                    <dd class="col-sm-8">
                                        @switch($product->status)
                                            @case('active')
                                                <span class="badge badge-success">Kích hoạt</span>
                                                @break
                                            @case('inactive')
                                                <span class="badge badge-danger">Vô hiệu</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $product->status }}</span>
                                        @endswitch
                                    </dd>

                                    <dt class="col-sm-4">Sản phẩm nổi bật:</dt>
                                    <dd class="col-sm-8">
                                        @if($product->is_featured)
                                            <span class="badge badge-warning">
                                                <i class="fas fa-star"></i> Có
                                            </span>
                                        @else
                                            <span class="badge badge-light">Không</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        @if($product->description)
                        <hr>
                        <h5>Mô tả sản phẩm:</h5>
                        <div class="border p-3 bg-light">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        @endif

                        @if($product->specification)
                        <hr>
                        <h5>Thông số kỹ thuật:</h5>
                        <div class="border p-3 bg-light">
                            {!! nl2br(e($product->specification)) !!}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Đánh giá -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Đánh giá & Phản hồi</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <h2 class="text-warning">{{ number_format($product->rating_avg ?? 0, 1) }}</h2>
                                    <div class="stars mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($product->rating_avg ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-muted">{{ $product->rating_count ?? 0 }} đánh giá</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(method_exists($product, 'reviews') && $product->reviews && $product->reviews->count() > 0)
                                    <div class="latest-reviews">
                                        <h6>Đánh giá gần nhất:</h6>
                                        @php
                                            $reviews = method_exists($product, 'approvedReviews')
                                                ? $product->approvedReviews()->latest()->limit(3)->get()
                                                : $product->reviews()->where('status', 'approved')->latest()->limit(3)->get();
                                        @endphp
                                        @foreach($reviews as $review)
                                        <div class="border-bottom pb-2 mb-2">
                                            <div class="d-flex justify-content-between">
                                                <strong>{{ $review->user->name ?? 'Khách hàng' }}</strong>
                                                <div class="stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 12px;"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="mb-1 small">{{ $review->comment }}</p>
                                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center text-muted">
                                        <i class="fas fa-comments fa-2x mb-2"></i>
                                        <p>Chưa có đánh giá nào</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Thống kê sản phẩm</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Trong giỏ hàng</span>
                                        <span class="info-box-number">
                                            {{ method_exists($product, 'cartItems') ? $product->cartItems->count() : 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-heart"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Trong wishlist</span>
                                        <span class="info-box-number">
                                            {{ method_exists($product, 'wishlistItems') ? $product->wishlistItems->count() : 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Đã bán</span>
                                        <span class="info-box-number">
                                            {{ method_exists($product, 'orderItems') ? $product->orderItems->sum('quantity') : 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-eye"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Lượt xem</span>
                                        <span class="info-box-number">{{ $product->views ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Hình ảnh -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh sản phẩm</h3>
                    </div>
                    <div class="card-body">
                        @if($product->image)
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="img-fluid img-thumbnail"
                                     style="max-height: 300px; cursor: pointer;"
                                     onclick="showImageModal('{{ asset('storage/' . $product->image) }}')">
                                <p class="text-muted small mt-2">Hình ảnh chính (Click để phóng to)</p>
                            </div>
                        @endif

                        @if($product->images && count($product->images) > 0)
                            <h6>Hình ảnh phụ:</h6>
                            <div class="row">
                                @foreach($product->images as $image)
                                    <div class="col-6 mb-2">
                                        <img src="{{ asset('storage/' . $image) }}"
                                             alt="{{ $product->name }}"
                                             class="img-fluid img-thumbnail"
                                             style="max-height: 150px; cursor: pointer;"
                                             onclick="showImageModal('{{ asset('storage/' . $image) }}')">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(!$product->image && (!$product->images || count($product->images) == 0))
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-3x mb-2"></i>
                                <p>Chưa có hình ảnh</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Currency Information -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin tiền tệ</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $currencyInfo = \App\Helpers\CurrencyHelper::getCurrencyInfo($product->currency ?? 'JPY');
                        @endphp
                        <dl class="row">
                            <dt class="col-sm-5">Loại tiền:</dt>
                            <dd class="col-sm-7">{{ $currencyInfo['name'] }}</dd>

                            <dt class="col-sm-5">Mã tiền tệ:</dt>
                            <dd class="col-sm-7"><code>{{ $product->currency ?? 'JPY' }}</code></dd>

                            <dt class="col-sm-5">Ký hiệu:</dt>
                            <dd class="col-sm-7"><strong>{{ $currencyInfo['symbol'] }}</strong></dd>

                            <dt class="col-sm-5">Vị trí ký hiệu:</dt>
                            <dd class="col-sm-7">
                                {{ $currencyInfo['symbol_position'] === 'before' ? 'Trước giá' : 'Sau giá' }}
                            </dd>

                            <dt class="col-sm-5">Số thập phân:</dt>
                            <dd class="col-sm-7">{{ $currencyInfo['decimal_places'] }}</dd>
                        </dl>

                        @if($product->discount > 0)
                            <hr>
                            <div class="alert alert-success">
                                <h6><i class="fas fa-percentage"></i> Giảm giá {{ $product->discount }}%</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <small>Giá gốc:</small><br>
                                        <del class="text-muted">{{ \App\Helpers\CurrencyHelper::formatPrice($product->price, $product->currency ?? 'JPY') }}</del>
                                    </div>
                                    <div class="col-12 mt-1">
                                        <small>Giá sau giảm:</small><br>
                                        <strong class="text-success">
                                            {{ \App\Helpers\CurrencyHelper::formatPrice($product->price - ($product->price * $product->discount / 100), $product->currency ?? 'JPY') }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Thông tin thêm -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin hệ thống</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-6">Ngày tạo:</dt>
                            <dd class="col-sm-6">{{ $product->created_at->format('d/m/Y H:i') }}</dd>

                            <dt class="col-sm-6">Cập nhật lần cuối:</dt>
                            <dd class="col-sm-6">{{ $product->updated_at->format('d/m/Y H:i') }}</dd>

                            <dt class="col-sm-6">Khoảng cách:</dt>
                            <dd class="col-sm-6">
                                <small class="text-muted">
                                    Tạo: {{ $product->created_at->diffForHumans() }}<br>
                                    Sửa: {{ $product->updated_at->diffForHumans() }}
                                </small>
                            </dd>

                            @if($product->created_by)
                            <dt class="col-sm-6">Người tạo:</dt>
                            <dd class="col-sm-6">ID: {{ $product->created_by }}</dd>
                            @endif

                            @if($product->updated_by)
                            <dt class="col-sm-6">Người sửa:</dt>
                            <dd class="col-sm-6">ID: {{ $product->updated_by }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thao tác nhanh</h3>
                    </div>
                    <div class="card-body">
                        <div class="btn-group-vertical w-100">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning mb-2">
                                <i class="fas fa-edit mr-1"></i> Chỉnh sửa sản phẩm
                            </a>

                            <button type="button" class="btn btn-info mb-2" onclick="toggleStatus()">
                                <i class="fas fa-toggle-{{ $product->status === 'active' ? 'on' : 'off' }} mr-1"></i>
                                {{ $product->status === 'active' ? 'Tắt kích hoạt' : 'Kích hoạt' }}
                            </button>

                            <button type="button" class="btn btn-secondary mb-2" onclick="toggleFeatured()">
                                <i class="fas fa-star mr-1"></i>
                                {{ $product->is_featured ? 'Bỏ nổi bật' : 'Đánh dấu nổi bật' }}
                            </button>

                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mb-2">
                                <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách
                            </a>

                            <button type="button" class="btn btn-danger" onclick="deleteProduct()">
                                <i class="fas fa-trash mr-1"></i> Xóa sản phẩm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $product->name }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modal-image" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sản phẩm <strong>"{{ $product->name }}"</strong>?</p>
                <p class="text-danger">Hành động này không thể khôi phục!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer_js')
<script>
    function showImageModal(imageSrc) {
        $('#modal-image').attr('src', imageSrc);
        $('#imageModal').modal('show');
    }

    function deleteProduct() {
        $('#deleteModal').modal('show');
    }

    function toggleStatus() {
        $.ajax({
            url: '{{ route("admin.products.toggleStatus", $product->id) }}',
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra!');
            }
        });
    }

    function toggleFeatured() {
        $.ajax({
            url: '{{ route("admin.products.toggleFeatured", $product->id) }}',
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra!');
            }
        });
    }
</script>
@endpush
