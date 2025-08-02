@extends('layouts.web.index')

@section('content')
    <section class="py-5 overflow-hidden">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Category</h2>

                        <div class="d-flex align-items-center">
                            <a href="#" class="btn btn-primary me-2">View All</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                                <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $item)
                                <a href="{{ route('category.show', $item->slug) }}"
                                    class="nav-link swiper-slide text-center">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="rounded-circle"
                                        alt="Category Thumbnail">
                                    <h4 class="fs-6 mt-3 fw-normal category-title">{{ $item->name }}</h4>
                                </a>
                            @endforeach

                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-2.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Breads & Sweets</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-3.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Fruits & Veges</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-4.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Beverages</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-5.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Meat Products</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-6.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Breads</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-7.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Fruits & Veges</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-8.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Breads & Sweets</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-1.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Fruits & Veges</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-1.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Beverages</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-1.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Meat Products</h4>
                            </a>
                            <a href="category.html" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('assets/web/images/category-thumb-1.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Breads</h4>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container-lg">

            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between my-4">

                        <h2 class="section-title">Best selling products</h2>

                        <div class="d-flex align-items-center">
                            <a href="#" class="btn btn-primary rounded-1">View All</a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div
                        class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                        @foreach ($product_best_saling as $item)
                            <div class="col">
                                <div class="product-item">
                                    <figure>
                                        <a href="{{route('homepage')}}" title="Product Title">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Product Thumbnail"
                                                class="tab-image">
                                        </a>
                                    </figure>
                                    <div class="d-flex flex-column text-center">
                                        <h3 class="fs-6 fw-normal">{{ $item->name }}</h3>
                                        <h4 class=fs-6 fw-normal fw-bold>{{ $item->jp_name }}</h4>
                                        <div>
                                            <span class="rating">
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-full"></use>
                                                </svg>
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-full"></use>
                                                </svg>
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-full"></use>
                                                </svg>
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-full"></use>
                                                </svg>
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-half"></use>
                                                </svg>
                                            </span>
                                            <span>(222)</span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            @if ($item->is_discounted)
                                                {{-- Giá gốc bị gạch --}}
                                                <del>
                                                    <x-currency :amount="$item->price" :currency="$item->currency" />
                                                </del>

                                                {{-- Giá sau giảm --}}
                                                <span class="text-dark fw-semibold">
                                                    <x-currency :amount="$item->discounted_price" :currency="$item->currency" />
                                                </span>

                                                {{-- Badge giảm giá --}}
                                                <span
                                                    class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">
                                                    {{ number_format($item->discount, 0) }}% OFF
                                                </span>
                                            @else
                                                {{-- Chỉ hiển thị giá bình thường khi không có giảm giá --}}
                                                <span class="text-dark fw-semibold">
                                                    <x-currency :amount="$item->price" :currency="$item->currency" />
                                                </span>
                                            @endif
                                        </div>
                                        <div class="button-area p-3 pt-0">
                                            <div class="row g-1 mt-2">
                                                <div class="col-3"><input type="number" name="quantity"
                                                        class="form-control border-dark-subtle input-number quantity"
                                                        value="1"></div>
                                                <div class="col-7"><a href="#"
                                                        class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                            width="18" height="18">
                                                            <use xlink:href="#cart"></use>
                                                        </svg> Add to Cart</a></div>
                                                <div class="col-2"><a href="#"
                                                        class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg
                                                            width="18" height="18">
                                                            <use xlink:href="#heart"></use>
                                                        </svg></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-2.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Whole Grain Oatmeal</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(41)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$54.00</del>
                                        <span class="text-dark fw-semibold">$50.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-3.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Sharp Cheddar Cheese Block</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(32)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$14.00</del>
                                        <span class="text-dark fw-semibold">$12.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-4.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Organic Baby Spinach</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-5.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Organic Spinach Leaves (Fresh Produce)</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-6.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Fresh Salmon</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-7.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Imported Italian Spaghetti Pasta</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-8.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Granny Smith Apples</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-9.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Organic 2% Reduced Fat Milk </h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-10.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Greek Style Plain Yogurt</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- / product-grid -->


                </div>
            </div>
        </div>
    </section>

    <section class="py-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">

                    <div class="banner-blocks">

                        <div class="banner-ad d-flex align-items-center large bg-info block-1"
                            style="background: url('images/banner-ad-1.jpg') no-repeat; background-size: cover;">
                            <div class="banner-content p-5">
                                <div class="content-wrapper text-light">
                                    <h3 class="banner-title text-light">Items on SALE</h3>
                                    <p>Discounts up to 30%</p>
                                    <a href="#" class="btn-link text-white">Shop Now</a>
                                </div>
                            </div>
                        </div>

                        <div class="banner-ad bg-success-subtle block-2"
                            style="background:url('images/banner-ad-2.jpg') no-repeat;background-size: cover">
                            <div class="banner-content align-items-center p-5">
                                <div class="content-wrapper text-light">
                                    <h3 class="banner-title text-light">Combo offers</h3>
                                    <p>Discounts up to 50%</p>
                                    <a href="#" class="btn-link text-white">Shop Now</a>
                                </div>
                            </div>
                        </div>

                        <div class="banner-ad bg-danger block-3"
                            style="background:url('images/banner-ad-3.jpg') no-repeat;background-size: cover">
                            <div class="banner-content align-items-center p-5">
                                <div class="content-wrapper text-light">
                                    <h3 class="banner-title text-light">Discount Coupons</h3>
                                    <p>Discounts up to 40%</p>
                                    <a href="#" class="btn-link text-white">Shop Now</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- / Banner Blocks -->

                </div>
            </div>
        </div>
    </section>

    <section id="featured-products" class="products-carousel">
        <div class="container-lg overflow-hidden py-5">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between my-4">

                        <h2 class="section-title">Featured products</h2>

                        <div class="d-flex align-items-center">
                            <a href="#" class="btn btn-primary me-2">View All</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                                <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="swiper">
                        <div class="swiper-wrapper">
                            @foreach ($products_1 as $item)
                                <div class="product-item swiper-slide" data-product-id="{{ $item->id }}">
                                    <figure>
                                        <a href="{{route('homepage')}}" title="Product Title">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Product Thumbnail"
                                                class="tab-image">
                                        </a>
                                    </figure>
                                    <div class="d-flex flex-column text-center">
                                        <h3 class="fs-6 fw-normal">{{ $item->name }}</h3>
                                        <h4 class="fs-6 fw-normal fw-bold">{{ $item->jp_name }}</h4>
                                        <div>
                                            <span class="rating">
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-full"></use>
                                                </svg>
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-full"></use>
                                                </svg>
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-full"></use>
                                                </svg>
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-full"></use>
                                                </svg>
                                                <svg width="18" height="18" class="text-warning">
                                                    <use xlink:href="#star-half"></use>
                                                </svg>
                                            </span>
                                            <span>(222)</span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            @if ($item->is_discounted)
                                                {{-- Giá gốc bị gạch --}}
                                                <del>
                                                    <x-currency :amount="$item->price" :currency="$item->currency" />
                                                </del>

                                                {{-- Giá sau giảm --}}
                                                <span class="text-dark fw-semibold">
                                                    <x-currency :amount="$item->discounted_price" :currency="$item->currency" />
                                                </span>

                                                {{-- Badge giảm giá --}}
                                                <span
                                                    class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">
                                                    {{ number_format($item->discount, 0) }}% OFF
                                                </span>
                                            @else
                                                {{-- Chỉ hiển thị giá bình thường khi không có giảm giá --}}
                                                <span class="text-dark fw-semibold">
                                                    <x-currency :amount="$item->price" :currency="$item->currency" />
                                                </span>
                                            @endif
                                        </div>
                                        <div class="button-area p-3 pt-0">
                                            <div class="row g-1 mt-2">
                                                <div class="col-3">
                                                    <input type="number" name="quantity"
                                                        class="form-control border-dark-subtle input-number quantity"
                                                        value="1" min="1" max="99">
                                                </div>
                                                <div class="col-7">
                                                    <button type="button"
                                                        class="btn btn-primary rounded-1 p-2 fs-7 btn-cart">
                                                        <svg width="18" height="18">
                                                            <use xlink:href="#cart"></use>
                                                        </svg>
                                                        <span class="btn-text">Add to Cart</span>
                                                    </button>
                                                </div>
                                                <div class="col-2">
                                                    <a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6">
                                                        <svg width="18" height="18">
                                                            <use xlink:href="#heart"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-11.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Pure Squeezed No Pulp Orange Juice</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-12.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Fresh Oranges</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-13.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Gourmet Dark Chocolate Bars</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-14.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Fresh Green Celery</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-15.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Sandwich Bread</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-16.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Honeycrisp Apples</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-17.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Whole Wheat Sandwich Bread</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-18.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Honeycrisp Apples</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!-- / products-carousel -->

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-lg">

            <div class="bg-secondary text-light py-5 my-5"
                style="background: url('images/banner-newsletter.jpg') no-repeat; background-size: cover;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-5 p-3">
                            <div class="section-header">
                                <h2 class="section-title display-5 text-light">Get 25% Discount on your first purchase
                                </h2>
                            </div>
                            <p>Just Sign Up & Register it now to become member.</p>
                        </div>
                        <div class="col-md-5 p-3">
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label d-none">Name</label>
                                    <input type="text" class="form-control form-control-md rounded-0"
                                        name="name" id="name" placeholder="Name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label d-none">Email</label>
                                    <input type="email" class="form-control form-control-md rounded-0"
                                        name="email" id="email" placeholder="Email Address">
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-dark btn-md rounded-0">Submit</button>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>

    <section id="popular-products" class="products-carousel">
        <div class="container-lg overflow-hidden py-5">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex justify-content-between my-4">

                        <h2 class="section-title">Most popular products</h2>

                        <div class="d-flex align-items-center">
                            <a href="#" class="btn btn-primary me-2">View All</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                                <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="swiper">
                        <div class="swiper-wrapper">

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-15.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Sandwich Bread</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-16.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Honeycrisp Apples</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-17.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Whole Wheat Sandwich Bread</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-18.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Honeycrisp Apples</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-19.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Sunstar Fresh Melon Juice</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-10.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Greek Style Plain Yogurt</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-11.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Pure Squeezed No Pulp Orange Juice</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-12.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Fresh Oranges</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-13.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Gourmet Dark Chocolate Bars</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!-- / products-carousel -->

                </div>
            </div>
        </div>
    </section>

    <section id="latest-products" class="products-carousel">
        <div class="container-lg overflow-hidden pb-5">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex justify-content-between my-4">

                        <h2 class="section-title">Just arrived</h2>

                        <div class="d-flex align-items-center">
                            <a href="#" class="btn btn-primary me-2">View All</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                                <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="swiper">
                        <div class="swiper-wrapper">

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-20.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Sunstar Fresh Melon Juice</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-1.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Whole Wheat Sandwich Bread</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-21.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Sunstar Fresh Melon Juice</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-22.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Gourmet Dark Chocolate</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-23.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Sunstar Fresh Melon Juice</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-10.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Greek Style Plain Yogurt</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-11.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Pure Squeezed No Pulp Orange Juice</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-12.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Fresh Oranges</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="{{route('homepage')}}" title="Product Title">
                                        <img src="{{ asset('assets/web/images/product-thumb-13.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Gourmet Dark Chocolate Bars</h3>
                                    <div>
                                        <span class="rating">
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-full"></use>
                                            </svg>
                                            <svg width="18" height="18" class="text-warning">
                                                <use xlink:href="#star-half"></use>
                                            </svg>
                                        </span>
                                        <span>(222)</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del>$24.00</del>
                                        <span class="text-dark fw-semibold">$18.00</span>
                                        <span
                                            class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                                            OFF</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3"><input type="number" name="quantity"
                                                    class="form-control border-dark-subtle input-number quantity"
                                                    value="1"></div>
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#cart"></use>
                                                    </svg> Add to Cart</a></div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                                                        height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- / products-carousel -->

                </div>
            </div>
        </div>
    </section>

    <section id="latest-blog" class="pb-4">
        <div class="container-lg">
            <div class="row">
                <div class="section-header d-flex align-items-center justify-content-between my-4">
                    <h2 class="section-title">Our Recent Blog</h2>
                    <a href="#" class="btn btn-primary">View All</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <article class="post-item card border-0 shadow-sm p-3">
                        <div class="image-holder zoom-effect">
                            <a href="#">
                                <img src="{{ asset('assets/web/images/post-thumbnail-1.jpg') }}" alt="post"
                                    class="card-img-top">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                                <div class="meta-date"><svg width="16" height="16">
                                        <use xlink:href="#calendar"></use>
                                    </svg>22 Aug 2021</div>
                                <div class="meta-categories"><svg width="16" height="16">
                                        <use xlink:href="#category"></use>
                                    </svg>tips & tricks</div>
                            </div>
                            <div class="post-header">
                                <h3 class="post-title">
                                    <a href="#" class="text-decoration-none">Top 10 casual look ideas to dress up
                                        your kids</a>
                                </h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim
                                    tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="post-item card border-0 shadow-sm p-3">
                        <div class="image-holder zoom-effect">
                            <a href="#">
                                <img src="{{ asset('assets/web/images/post-thumbnail-2.jpg') }}" alt="post"
                                    class="card-img-top">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                                <div class="meta-date"><svg width="16" height="16">
                                        <use xlink:href="#calendar"></use>
                                    </svg>25 Aug 2021</div>
                                <div class="meta-categories"><svg width="16" height="16">
                                        <use xlink:href="#category"></use>
                                    </svg>trending</div>
                            </div>
                            <div class="post-header">
                                <h3 class="post-title">
                                    <a href="#" class="text-decoration-none">Latest trends of wearing street wears
                                        supremely</a>
                                </h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim
                                    tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="post-item card border-0 shadow-sm p-3">
                        <div class="image-holder zoom-effect">
                            <a href="#">
                                <img src="{{ asset('assets/web/images/post-thumbnail-3.jpg') }}" alt="post"
                                    class="card-img-top">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                                <div class="meta-date"><svg width="16" height="16">
                                        <use xlink:href="#calendar"></use>
                                    </svg>28 Aug 2021</div>
                                <div class="meta-categories"><svg width="16" height="16">
                                        <use xlink:href="#category"></use>
                                    </svg>inspiration</div>
                            </div>
                            <div class="post-header">
                                <h3 class="post-title">
                                    <a href="#" class="text-decoration-none">10 Different Types of comfortable
                                        clothes ideas for women</a>
                                </h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim
                                    tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-4 my-4">
        <div class="container-lg">

            <div class="bg-warning pt-5 rounded-5">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-4">
                            <h2 class="mt-5">Download Organic App</h2>
                            <p>Online Orders made easy, fast and reliable</p>
                            <div class="d-flex gap-2 flex-wrap mb-5">
                                <a href="#" title="App store"><img
                                        src="{{ asset('assets/web/images/img-app-store.png') }}" alt="app-store"></a>
                                <a href="#" title="Google Play"><img
                                        src="{{ asset('assets/web/images/img-google-play.png') }}"
                                        alt="google-play"></a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <img src="{{ asset('assets/web/images/banner-onlineapp.png') }}" alt="phone"
                                class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="py-4">
        <div class="container-lg">
            <h2 class="my-4">People are also looking for</h2>
            <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
            <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
        </div>
    </section>

    <section class="py-5">
        <div class="container-lg">
            <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5">
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#package"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>Free delivery</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#secure"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>100% secure payment</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#quality"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>Quality guarantee</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#savings"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>guaranteed savings</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#offers"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>Daily offers</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('header_css')
    <style>
        img.rounded-circle {
            height: 161px;
            width: 161px;
        }
    </style>
@endpush
@push('header_css')
<style>
/* Loading animation cho button */
.btn-loading {
    position: relative;
    pointer-events: none;
    opacity: 0.7;
}

.btn-loading .btn-text {
    opacity: 0;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    margin: auto;
    border: 2px solid transparent;
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Cart bounce animation */
.cart-animation {
    animation: cartBounce 0.6s ease-out;
}

@keyframes cartBounce {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

/* Product fly animation */
.product-fly {
    position: fixed;
    pointer-events: none;
    z-index: 9999;
    transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* Toast notifications */
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #28a745;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 10000;
    transform: translateX(400px);
    transition: transform 0.3s ease;
    font-size: 14px;
    font-weight: 500;
}

.toast.show {
    transform: translateX(0);
}

.toast.error {
    background: #dc3545;
}

.toast.warning {
    background: #ffc107;
    color: #000;
}

/* Cart badge enhancement */
.cart-badge {
    animation: pulse 0.5s ease-in-out;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

/* Improved cart item animations */
.cart-item {
    transition: all 0.3s ease;
}

.cart-item:hover {
    background-color: #f8f9fa;
}

.cart-item.removing {
    opacity: 0;
    transform: translateX(-100%);
    margin-bottom: 0;
    padding-top: 0;
    padding-bottom: 0;
}
</style>
@endpush

@push('footer_js')
<script>
// Cart configuration
window.cartConfig = {
    apiBase: '{{ url("/api/cart") }}',
    csrfToken: '{{ csrf_token() }}',
    currency: 'JPY',
    currencySymbol: '¥'
};

// Enhanced CartManager class
class CartManager {
    constructor() {
        this.apiBase = window.cartConfig.apiBase;
        this.csrfToken = window.cartConfig.csrfToken;
        this.cart = null;
        this.isLoading = false;
        this.init();
    }

    async init() {
        try {
            await this.loadCart();
            this.setupEventListeners();
            console.log('Cart Manager initialized successfully');
        } catch (error) {
            console.error('Cart Manager initialization failed:', error);
        }
    }

    // API Methods
    async apiCall(url, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        try {
            const response = await fetch(url, {
                ...defaultOptions,
                ...options,
                headers: { ...defaultOptions.headers, ...options.headers }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || `HTTP ${response.status}: ${response.statusText}`);
            }

            return data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    }

    async loadCart() {
        try {
            const response = await this.apiCall(this.apiBase);
            this.cart = response.data;
            this.updateCartUI();
            this.updateCartBadge(this.cart.totals?.total_items || 0);
        } catch (error) {
            console.error('Load cart error:', error);
            this.showToast('Không thể tải giỏ hàng', 'error');
        }
    }

    async addToCart(productId, quantity = 1, buttonElement = null) {
        if (this.isLoading) return;

        try {
            this.isLoading = true;

            if (buttonElement) {
                this.setButtonLoading(buttonElement, true);
            }

            const response = await this.apiCall(`${this.apiBase}/add`, {
                method: 'POST',
                body: JSON.stringify({
                    product_id: parseInt(productId),
                    quantity: parseInt(quantity)
                })
            });

            if (response.success) {
                // Update local cart data
                await this.loadCart();

                // Show success animations
                this.animateAddToCart(buttonElement);
                this.showToast(response.message, 'success');

                // Update cart badge with animation
                this.updateCartBadge(response.data.totals.total_items);
            }

            return response;

        } catch (error) {
            this.showToast(error.message || 'Có lỗi xảy ra khi thêm sản phẩm', 'error');
            throw error;
        } finally {
            this.isLoading = false;
            if (buttonElement) {
                this.setButtonLoading(buttonElement, false);
            }
        }
    }

    async updateQuantity(itemId, quantity) {
        try {
            const response = await this.apiCall(`${this.apiBase}/item/${itemId}`, {
                method: 'PUT',
                body: JSON.stringify({ quantity: parseInt(quantity) })
            });

            if (response.success) {
                await this.loadCart();
                this.showToast('Đã cập nhật số lượng', 'success');
            }

            return response;
        } catch (error) {
            this.showToast(error.message || 'Có lỗi khi cập nhật số lượng', 'error');
            throw error;
        }
    }

    async removeItem(itemId, itemElement = null) {
        try {
            // Animate removal
            if (itemElement) {
                itemElement.classList.add('removing');
            }

            const response = await this.apiCall(`${this.apiBase}/item/${itemId}`, {
                method: 'DELETE'
            });

            if (response.success) {
                this.showToast(response.message, 'success');

                // Wait for animation then update UI
                setTimeout(async () => {
                    if (response.data.is_empty) {
                        this.showEmptyCart();
                    } else {
                        await this.loadCart();
                    }
                    this.updateCartBadge(response.data.totals.total_items);
                }, 300);
            }

            return response;
        } catch (error) {
            // Remove animation class on error
            if (itemElement) {
                itemElement.classList.remove('removing');
            }
            this.showToast(error.message || 'Có lỗi khi xóa sản phẩm', 'error');
            throw error;
        }
    }

    // UI Methods
    setupEventListeners() {
        // Add to cart buttons
        document.addEventListener('click', async (e) => {
            if (e.target.closest('.btn-cart')) {
                e.preventDefault();
                await this.handleAddToCart(e.target.closest('.btn-cart'));
            }
        });

        // Cart quantity controls
        document.addEventListener('click', async (e) => {
            if (e.target.matches('.quantity-btn')) {
                await this.handleQuantityChange(e.target);
            }

            if (e.target.closest('.delete-btn')) {
                await this.handleDeleteItem(e.target.closest('.delete-btn'));
            }
        });

        // Quantity input validation
        document.addEventListener('input', (e) => {
            if (e.target.matches('.quantity')) {
                this.validateQuantityInput(e.target);
            }
        });
    }

    async handleAddToCart(button) {
        const productItem = button.closest('.product-item');
        const productId = productItem?.dataset.productId;
        const quantityInput = productItem?.querySelector('.quantity');
        const quantity = quantityInput ? Math.max(1, parseInt(quantityInput.value) || 1) : 1;

        if (!productId) {
            this.showToast('Không tìm thấy thông tin sản phẩm', 'error');
            return;
        }

        // Validate quantity
        if (quantity < 1 || quantity > 99) {
            this.showToast('Số lượng phải từ 1 đến 99', 'warning');
            return;
        }

        await this.addToCart(productId, quantity, button);
    }

    async handleQuantityChange(button) {
        const cartItem = button.closest('.cart-item');
        const itemId = cartItem?.dataset.itemId;
        const quantityInput = cartItem?.querySelector('.quantity');

        if (!itemId || !quantityInput) return;

        const currentQuantity = parseInt(quantityInput.value) || 1;
        let newQuantity = currentQuantity;

        if (button.textContent.trim() === '+') {
            newQuantity = Math.min(currentQuantity + 1, 99);
        } else if (button.textContent.trim() === '−') {
            newQuantity = Math.max(currentQuantity - 1, 1);
        }

        if (newQuantity !== currentQuantity) {
            quantityInput.value = newQuantity;
            await this.updateQuantity(itemId, newQuantity);
        }
    }

    async handleDeleteItem(button) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            const cartItem = button.closest('.cart-item');
            const itemId = cartItem?.dataset.itemId;

            if (itemId) {
                await this.removeItem(itemId, cartItem);
            }
        }
    }

    validateQuantityInput(input) {
        let value = parseInt(input.value) || 1;
        value = Math.max(1, Math.min(99, value));
        input.value = value;
    }

    // Animation Methods
    animateAddToCart(button) {
        // Cart icon bounce
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.classList.remove('cart-animation');
            setTimeout(() => cartIcon.classList.add('cart-animation'), 10);
            setTimeout(() => cartIcon.classList.remove('cart-animation'), 600);
        }

        // Product fly animation
        if (button) {
            const productImg = button.closest('.product-item')?.querySelector('img');
            if (productImg && cartIcon) {
                this.flyToCart(productImg, cartIcon);
            }
        }
    }

    flyToCart(productImg, cartIcon) {
        const flyingImg = productImg.cloneNode(true);
        const productRect = productImg.getBoundingClientRect();
        const cartRect = cartIcon.getBoundingClientRect();

        flyingImg.className = 'product-fly';
        flyingImg.style.cssText = `
            position: fixed;
            left: ${productRect.left}px;
            top: ${productRect.top}px;
            width: ${productRect.width}px;
            height: ${productRect.height}px;
            z-index: 9999;
            pointer-events: none;
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        `;

        document.body.appendChild(flyingImg);

        requestAnimationFrame(() => {
            flyingImg.style.cssText += `
                left: ${cartRect.left + cartRect.width/2 - 15}px;
                top: ${cartRect.top + cartRect.height/2 - 15}px;
                width: 30px;
                height: 30px;
                opacity: 0;
            `;
        });

        setTimeout(() => flyingImg.remove(), 800);
    }

    updateCartUI() {
        if (!this.cart?.items || this.cart.items.length === 0) {
            this.showEmptyCart();
            return;
        }

        const cartItemsContainer = document.querySelector('.cart-items');
        if (!cartItemsContainer) return;

        cartItemsContainer.innerHTML = this.cart.items.map(item => `
            <div class="cart-item" data-item-id="${item.id}">
                <img src="/storage/${item.product.image}" alt="${item.product.name}" class="item-image">
                <div class="item-details">
                    <div class="item-name">${item.product.name}</div>
                    <div class="item-description">${item.product.jp_name || ''}</div>
                    <div class="item-controls">
                        <button class="quantity-btn">−</button>
                        <input type="text" class="quantity" value="${item.quantity}" readonly>
                        <button class="quantity-btn">+</button>
                        <div class="item-price">${item.formatted_line_total}</div>
                        <button class="delete-btn" title="Xóa sản phẩm">
                            <svg viewBox="0 0 24 24">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

        this.updateTotals(this.cart.totals);
        this.showCartActions();
    }

    showEmptyCart() {
        const cartItemsContainer = document.querySelector('.cart-items');
        if (cartItemsContainer) {
            cartItemsContainer.innerHTML = `
                <div style="text-align: center; padding: 40px 20px; color: #999;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="margin-bottom: 16px; opacity: 0.5;">
                        <path d="M7,18C5.9,18 5,18.9 5,20S5.9,22 7,22 9,20.1 9,20 8.1,18 7,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5H5.21L4.27,2H1M17,18C15.9,18 15,18.9 15,20S15.9,22 17,22 19,20.1 19,20 18.1,18 17,18Z" />
                    </svg>
                    <div style="font-size: 16px; margin-bottom: 8px;">Giỏ hàng trống</div>
                    <div style="font-size: 14px;">Hãy thêm sản phẩm vào giỏ hàng của bạn</div>
                </div>
            `;
        }

        this.updateTotals({ subtotal: 0, total_items: 0, formatted_subtotal: '¥ 0' });

        const cartActions = document.querySelector('.cart-actions');
        if (cartActions) {
            cartActions.innerHTML = `
                <button class="cart-btn continue-btn" onclick="toggleCart()">Tiếp tục mua hàng</button>
            `;
        }
    }

    showCartActions() {
        const cartActions = document.querySelector('.cart-actions');
        if (cartActions) {
            cartActions.innerHTML = `
                <button class="cart-btn view-cart-btn">Xem giỏ hàng</button>
                <button class="cart-btn checkout-btn">Tiến hành đặt hàng</button>
                <button class="cart-btn continue-btn" onclick="toggleCart()">Tiếp tục mua hàng</button>
            `;
        }
    }

    updateCartBadge(totalItems) {
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            const currentItems = parseInt(badge.textContent) || 0;
            badge.textContent = totalItems;

            if (totalItems > 0) {
                badge.style.display = 'block';
                // Add pulse animation if items increased
                if (totalItems > currentItems) {
                    badge.classList.remove('cart-animation');
                    setTimeout(() => badge.classList.add('cart-animation'), 10);
                    setTimeout(() => badge.classList.remove('cart-animation'), 500);
                }
            } else {
                badge.style.display = 'none';
            }
        }
    }

    updateTotals(totals) {
        const totalAmount = document.querySelector('.total-amount');
        if (totalAmount) {
            totalAmount.textContent = totals.formatted_subtotal;
        }
    }

    setButtonLoading(button, isLoading) {
        if (isLoading) {
            button.classList.add('btn-loading');
            button.disabled = true;
        } else {
            button.classList.remove('btn-loading');
            button.disabled = false;
        }
    }

    showToast(message, type = 'success') {
        // Remove existing toasts
        document.querySelectorAll('.toast').forEach(toast => toast.remove());

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.cartManager = new CartManager();
});
</script>
@endpush
