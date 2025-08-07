@extends('layouts.web.default')

@section('title', 'All Products' . ($selectedCategory ? ' - ' . $selectedCategory->name : ''))

@section('content')
    <div class="container-lg py-5">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-2">
                            @if ($selectedCategory)
                                Products in {{ $selectedCategory->name }}
                            @else
                                All Products
                            @endif
                        </h1>
                        <p class="text-muted mb-0">{{ $products->total() }} products found</p>
                    </div>

                    <!-- Search Form -->
                    <div class="d-flex gap-2">
                        <form method="GET" class="d-flex">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <input type="search" name="search" class="form-control" placeholder="Search products..."
                                value="{{ request('search') }}" style="min-width: 200px;">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filter by Category</h5>
                    </div>
                    <div class="card-body">
                        <!-- All Products Link -->
                        <div class="mb-3">
                            <a href="{{ route('products.all') }}"
                                class="d-flex justify-content-between align-items-center text-decoration-none {{ !request('category') ? 'fw-bold text-primary' : 'text-dark' }}">
                                <span>All Categories</span>
                                <span class="badge bg-light text-dark">{{ $products->total() }}</span>
                            </a>
                        </div>

                        <!-- Category List -->
                        @foreach ($categories as $category)
                            <div class="mb-2">
                                <a href="{{ route('products.all', ['category' => $category->id]) }}"
                                    class="d-flex justify-content-between align-items-center text-decoration-none {{ request('category') == $category->id ? 'fw-bold text-primary' : 'text-dark' }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="badge bg-light text-dark">{{ $category->products_count }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Sort By</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" id="sortForm">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <div class="mb-3">
                                <select name="sort" class="form-select"
                                    onchange="document.getElementById('sortForm').submit()">
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z
                                    </option>
                                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price Low to
                                        High</option>
                                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest
                                        Rated</option>
                                    <option value="discount" {{ request('sort') == 'discount' ? 'selected' : '' }}>Best
                                        Discount</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="per_page" class="form-label">Products per page:</label>
                                <select name="per_page" id="per_page" class="form-select"
                                    onchange="document.getElementById('sortForm').submit()">
                                    <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12
                                    </option>
                                    <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                                    <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>36</option>
                                    <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9 col-md-8">
                @if ($products->count() > 0)
                    <div class="product-grid row row-cols-2 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                        @foreach ($products as $product)
                            <div class="col">
                                <div class="product-item card h-100" data-product-id="{{ $product->id }}>
                                    <figure class="mb-0">
                                        <a href="{{ route('products.show', $product->slug) }}"
                                            title="{{ $product->name }}">
                                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/web/images/product-placeholder.png') }}"
                                                alt="{{ $product->name }}" class="card-img-top"
                                                style="height: 200px; object-fit: cover;">
                                        </a>
                                    </figure>

                                    <div class="card-body d-flex flex-column text-center">
                                        <h3 class="card-title fs-6 fw-normal mb-2">
                                            <a href="{{ route('products.show', $product->slug) }}"
                                                class="text-decoration-none text-dark">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <h4 class="fs-6 fw-normal fw-bold">{{ $product->jp_name }}</h4>
                                        <!-- Rating -->
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

                                        <!-- Price -->
                                        <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                            @if ($product->is_discounted)
                                                <del class="text-muted">{{ $product->formatted_price }}</del>
                                                <span
                                                    class="text-dark fw-semibold">{{ $product->formatted_discounted_price }}</span>
                                                <span
                                                    class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">
                                                    {{ number_format($product->discount) }}% OFF
                                                </span>
                                            @else
                                                <span class="text-dark fw-semibold">{{ $product->formatted_price }}</span>
                                            @endif
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="button-area p-3 pt-0">
                                            <div class="row g-1 mt-2">
                                                <div class="col-4">
                                                    <input type="number" name="quantity"
                                                        class="form-control border-dark-subtle input-number quantity"
                                                        value="1" min="1" max="99">
                                                </div>
                                                <div class="col-8">
                                                    <button type="button"
                                                        class="btn btn-primary rounded-1 p-2 fs-7 btn-cart">
                                                        <svg width="18" height="18">
                                                            <use xlink:href="#cart"></use>
                                                        </svg>
                                                        <span class="btn-text d-none d-sm-inline"> Add to Cart</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <svg width="64" height="64" class="text-muted">
                                <use xlink:href="#search"></use>
                            </svg>
                        </div>
                        <h3>No products found</h3>
                        <p class="text-muted">Try adjusting your search or filter criteria</p>
                        <a href="{{ route('products.all') }}" class="btn btn-primary">View All Products</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('footer_js')
        {{-- <script>
            // Add to Cart functionality
            document.addEventListener('DOMContentLoaded', function() {
                // Add to cart buttons
                document.querySelectorAll('.btn-cart').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.productId;
                        const quantityInput = this.closest('.button-area').querySelector('.quantity');
                        const quantity = quantityInput.value;

                        // Add your cart logic here
                        console.log(`Adding product ${productId} with quantity ${quantity} to cart`);

                        // Example AJAX call (uncomment and modify as needed):
                        /*
                        fetch('/cart/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                alert('Product added to cart successfully!');
                            } else {
                                alert('Error adding product to cart');
                            }
                        });
                        */
                    });
                });

                // Wishlist buttons
                document.querySelectorAll('.btn-wishlist').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.productId;

                        // Add your wishlist logic here
                        console.log(`Adding product ${productId} to wishlist`);

                        // Toggle heart icon
                        const heartIcon = this.querySelector('svg');
                        this.classList.toggle('btn-outline-dark');
                        this.classList.toggle('btn-danger');
                    });
                });
            });
        </script> --}}
        <script>
            // Cart configuration
            window.cartConfig = {
                apiBase: '{{ url('/api/cart') }}',
                csrfToken: '{{ csrf_token() }}',
                currency: 'JPY',
                currencySymbol: '¥'
            };
        </script>
    @endpush

@endsection
