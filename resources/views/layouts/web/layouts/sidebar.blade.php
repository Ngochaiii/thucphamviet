<div class="preloader-wrapper">
    <div class="preloader">
    </div>
</div>

{{-- resources/views/components/sidebar.blade.php --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
    <div class="offcanvas-header justify-content-between">
        <h4 class="fw-normal text-uppercase fs-6">Menu</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
            @forelse($categories ?? [] as $category)
                <li class="nav-item border-dashed {{ $loop->first ? 'active' : '' }}">
                    <a href="#" class="nav-link d-flex align-items-center gap-3 text-dark p-2 text-decoration-none">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}"
                                 alt="{{ $category->name }}"
                                 style="height: 30px;width: 30px;"
                                 class="rounded-circle object-fit-cover flex-shrink-0">
                        @else
                            <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width: 24px; height: 24px; font-size: 12px; font-weight: 600;">
                                {{ strtoupper(substr($category->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-truncate">{{ $category->name }}</span>
                    </a>
                </li>
            @empty
                <li class="nav-item">
                    <span class="nav-link text-muted">Không có danh mục nào</span>
                </li>
            @endforelse
        </ul>
    </div>
</div>
