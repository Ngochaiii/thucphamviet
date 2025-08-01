{{-- resources/views/components/product-grid.blade.php --}}
<section class="pb-5">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-4">
                    <h2 class="section-title">{{ $title ?? 'Best selling products' }}</h2>
                    <div class="d-flex align-items-center">
                        @if(isset($viewAllLink))
                            <a href="{{ $viewAllLink }}" class="btn btn-primary rounded-1">View All</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                    @forelse($products as $product)
                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}">
                                        @if($product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                                 alt="{{ $product->name }}"
                                                 class="tab-image">
                                        @else
                                            <img src="{{ asset('assets/web/images/product-thumb-1.png') }}"
                                                 alt="{{ $product->name }}"
                                                 class="tab-image">
                                        @endif
                                    </a>
                                </figure>

                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">{{ Str::limit($product->name, 50) }}</h3>

                                    {{-- Rating --}}
                                    <div>
                                        <span class="rating">
                                            @php
                                                $rating = $product->rating ?? 4.5;
                                                $fullStars = floor($rating);
                                                $halfStar = ($rating - $fullStars) >= 0.5;
                                            @endphp

                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $fullStars)
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
                                        <span>({{ $product->reviews_count ?? rand(10, 300) }})</span>
                                    </div>

                                    {{-- Price --}}
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        @if($product->sale_price && $product->sale_price < $product->price)
                                            <del>${{ number_format($product->price, 2) }}</del>
                                            <span class="text-dark fw-semibold">${{ number_format($product->sale_price, 2) }}</span>
                                            @php
                                                $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                                            @endphp
                                            <span class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">
                                                {{ $discount }}% OFF
                                            </span>
                                        @else
                                            <span class="text-dark fw-semibold">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>

                                    {{-- Actions --}}
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3">
                                                <input type="number"
                                                       name="quantity"
                                                       class="form-control border-dark-subtle input-number quantity"
                                                       value="1"
                                                       min="1"
                                                       data-product-id="{{ $product->id }}">
                                            </div>
                                            <div class="col-7">
                                                <a href="#"
                                                   class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"
                                                   data-product-id="{{ $product->id }}"
                                                   onclick="addToCart({{ $product->id }})">
                                                    <svg width="18" height="18"><use xlink:href="#cart"></use></svg>
                                                    Add to Cart
                                                </a>
                                            </div>
                                            <div class="col-2">
                                                <a href="#"
                                                   class="btn btn-outline-dark rounded-1 p-2 fs-6 btn-wishlist"
                                                   data-product-id="{{ $product->id }}"
                                                   onclick="toggleWishlist({{ $product->id }})">
                                                    <svg width="18" height="18"><use xlink:href="#heart"></use></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h4 class="text-muted">Không có sản phẩm nào</h4>
                            <p class="text-muted">Hiện tại chưa có sản phẩm trong danh mục này</p>
                        </div>
                    @endforelse
                </div>
                <!-- / product-grid -->
            </div>
        </div>
    </div>
</section>
