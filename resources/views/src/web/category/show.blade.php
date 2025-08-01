{{-- resources/views/web/category/show.blade.php --}}
@extends('layouts.web.index')

@section('content')
    <div class="container-lg">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="my-4">
            <ol class="breadcrumb">
                @foreach ($breadcrumb as $item)
                    @if ($item['url'])
                        <li class="breadcrumb-item">
                            <a href="{{ $item['url'] }}" class="text-decoration-none">{{ $item['name'] }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $item['name'] }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>

        {{-- Category Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    @if ($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                            class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                    @endif
                    <div>
                        <h1 class="h2 mb-2">{{ $category->name }}</h1>
                        @if ($category->description)
                            <p class="text-muted mb-1">{{ $category->description }}</p>
                        @endif
                        <small class="text-muted">{{ $products->total() }} sản phẩm</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Sidebar Filters --}}
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Bộ lọc sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" id="filterForm">
                            {{-- Search --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tìm kiếm</label>
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                    placeholder="Nhập tên sản phẩm...">
                            </div>

                            {{-- Price Range --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Khoảng giá</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="min_price" class="form-control" placeholder="Từ $"
                                            value="{{ request('min_price') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_price" class="form-control" placeholder="Đến $"
                                            value="{{ request('max_price') }}">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    Giá từ ${{ $filterOptions['price_range']['min'] }}
                                    đến ${{ $filterOptions['price_range']['max'] }}
                                </small>
                            </div>

                            {{-- Sort --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sắp xếp</label>
                                <select name="sort" class="form-select">
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z
                                    </option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá
                                        thấp đến cao</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá
                                        cao đến thấp</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất
                                    </option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-2"></i>Áp dụng bộ lọc
                                </button>
                                <a href="{{ route('category.show', $category->slug) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Xóa bộ lọc
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Child Categories --}}
                @if ($category->children->isNotEmpty())
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-grid me-2"></i>Danh mục con</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach ($category->children as $child)
                                    <a href="{{ route('category.show', $child->slug) }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center border-0">
                                        @if ($child->image)
                                            <img src="{{ asset('storage/' . $child->image) }}" alt="{{ $child->name }}"
                                                class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; font-weight: 600;">
                                                {{ strtoupper(substr($child->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $child->name }}</h6>
                                            <small class="text-muted">{{ $child->products_count ?? 0 }} sản phẩm</small>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Products Grid --}}
            <div class="col-lg-9 col-md-8">
                {{-- Results Info & Sort --}}
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
                    <div>
                        <span class="fw-semibold">
                            Hiển thị {{ $products->firstItem() }}-{{ $products->lastItem() }}
                            của {{ $products->total() }} sản phẩm
                        </span>
                        @if (request('search'))
                            <span class="text-muted">cho "{{ request('search') }}"</span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label mb-0 me-2">Hiển thị:</label>
                        <select name="per_page" class="form-select form-select-sm" style="width: auto;"
                            onchange="changePerPage(this.value)">
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="40" {{ request('per_page') == 40 ? 'selected' : '' }}>40</option>
                            <option value="60" {{ request('per_page') == 60 ? 'selected' : '' }}>60</option>
                        </select>
                    </div>
                </div>

                {{-- Products Grid --}}
                @if ($products->count() > 0)
                    <div
                        class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-4">
                        @foreach ($products as $product)
                            <div class="col">
                                <div class="product-item border rounded shadow-sm h-100">
                                    <figure class="mb-0">
                                        <a href="" title="{{ $product->name }}">
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                    alt="{{ $product->name }}" class="card-img-top"
                                                    style="height: 200px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/web/images/product-thumb-1.png') }}"
                                                    alt="{{ $product->name }}" class="card-img-top"
                                                    style="height: 200px; object-fit: cover;">
                                            @endif

                                            {{-- Sale Badge --}}
                                            @if ($product->discount && $product->discount > 0)
                                                @php
                                                    $discount = round(
                                                        (($product->price - $product->sale_price) / $product->price) *
                                                            100,
                                                    );
                                                @endphp
                                                <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                                                    -{{ $discount }}%
                                                </span>
                                            @endif
                                        </a>
                                    </figure>
                                    <div class="card-body d-flex flex-column text-center">
                                        <h3 class="fs-6 fw-normal mb-2">{{ Str::limit($product->name, 50) }}</h3>
                                        {{-- Rating --}}
                                        @if ($product->unit)
                                            <p>Đơn vị : {{ $product->unit->name }} ({{ $product->unit->symbol }})</p>
                                        @endif
                                        <div class="">
                                            <span class="rating">
                                                @php
                                                    $rating = $product->rating_avg ?? 0;
                                                    $fullStars = floor($rating);
                                                    $halfStar = $rating - $fullStars >= 0.5;
                                                @endphp

                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $fullStars)
                                                        <svg width="18" height="18" class="text-warning">
                                                            <use xlink:href="#star-full"></use>
                                                        </svg>
                                                    @elseif($i == $fullStars + 1 && $halfStar)
                                                        <svg width="18" height="18" class="text-warning">
                                                            <use xlink:href="#star-half"></use>
                                                        </svg>
                                                    @else
                                                        <svg width="18" height="18" class="text-muted">
                                                            <use xlink:href="#star-empty"></use>
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </span>
                                            <span class="text-muted">({{ $product->rating_count ?? 0 }})</span>
                                        </div>

                                        {{-- Price --}}
                                        <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                            @if ($product->sale_price && $product->sale_price < $product->price)
                                                <del class="text-muted">${{ number_format($product->price, 2) }}</del>
                                                <span
                                                    class="text-dark fw-semibold">${{ number_format($product->sale_price, 2) }}</span>
                                                <span
                                                    class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">
                                                    {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                                    OFF
                                                </span>
                                            @else
                                                <span
                                                    class="text-dark fw-semibold">¥{{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>

                                        {{-- Actions --}}
                                        <div class="button-area p-3 pt-0">
                                            <div class="row g-1">
                                                <div class="col-3">
                                                    <input type="number" name="quantity"
                                                        class="form-control border-dark-subtle input-number quantity"
                                                        value="1" min="1"
                                                        data-product-id="{{ $product->id }}">
                                                </div>
                                                <div class="col-7">
                                                    <a href="#"
                                                        class="btn btn-primary rounded-1 p-2 fs-7 btn-cart w-100"
                                                        data-product-id="{{ $product->id }}"
                                                        onclick="addToCart({{ $product->id }})">
                                                        <svg width="18" height="18">
                                                            <use xlink:href="#cart"></use>
                                                        </svg>
                                                        Add to Cart
                                                    </a>
                                                </div>
                                                <div class="col-2">
                                                    <a href="#"
                                                        class="btn btn-outline-dark rounded-1 p-2 fs-6 btn-wishlist w-100"
                                                        data-product-id="{{ $product->id }}"
                                                        onclick="toggleWishlist({{ $product->id }})">
                                                        <svg width="18" height="18">
                                                            <use xlink:href="#heart"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                        </div>
                        <h4 class="text-muted mb-3">Không tìm thấy sản phẩm nào</h4>
                        <p class="text-muted mb-4">
                            @if (request('search'))
                                Không tìm thấy sản phẩm nào cho từ khóa "{{ request('search') }}"
                            @else
                                Thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác
                            @endif
                        </p>
                        <a href="{{ route('category.show', $category->slug) }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>Xem tất cả sản phẩm
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('footer_js')
    <script>
        function changePerPage(value) {
            const url = new URL(window.location);
            url.searchParams.set('per_page', value);
            window.location.href = url.toString();
        }

        function addToCart(productId) {
            const quantity = document.querySelector(`input[data-product-id="${productId}"]`).value;

            // TODO: Implement add to cart AJAX
            console.log('Add to cart:', productId, 'Quantity:', quantity);

            // Show success message
            alert('Đã thêm sản phẩm vào giỏ hàng!');
        }

        function toggleWishlist(productId) {
            // TODO: Implement wishlist toggle AJAX
            console.log('Toggle wishlist:', productId);

            // Toggle heart icon
            const heartBtn = document.querySelector(`[data-product-id="${productId}"].btn-wishlist`);
            heartBtn.classList.toggle('btn-outline-dark');
            heartBtn.classList.toggle('btn-danger');
        }

        // Auto submit form when filter changes
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const filterInputs = filterForm.querySelectorAll('input, select');

            filterInputs.forEach(input => {
                if (input.type !== 'submit') {
                    input.addEventListener('change', function() {
                        // Optional: Auto submit form
                        // filterForm.submit();
                    });
                }
            });
        });
    </script>
@endpush
