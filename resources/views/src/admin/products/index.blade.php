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
                                <li class="breadcrumb-item active">Quản lý sản phẩm</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <!-- Thông báo lỗi -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Thông báo thành công -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Thông báo lỗi -->
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách sản phẩm</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus mr-1"></i> Thêm sản phẩm
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <form action="{{ route('admin.products.index') }}" method="GET" class="form-inline">
                                        <div class="input-group mr-2">
                                            <input type="text" class="form-control" name="searchText"
                                                placeholder="Tìm theo tên sản phẩm..." value="{{ request('searchText') }}">
                                            <select name="searchBy" class="form-control">
                                                <option value="name"
                                                    {{ request('searchBy') == 'name' ? 'selected' : '' }}>Tên</option>
                                                <option value="description"
                                                    {{ request('searchBy') == 'description' ? 'selected' : '' }}>Mô tả
                                                </option>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <select name="category_id" class="form-control mr-2">
                                            <option value="">-- Tất cả danh mục --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select name="status" class="form-control mr-2">
                                            <option value="">-- Tất cả trạng thái --</option>
                                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                                Kích hoạt</option>
                                            <option value="inactive"
                                                {{ request('status') == 'inactive' ? 'selected' : '' }}>Vô hiệu</option>
                                        </select>

                                        <select name="is_featured" class="form-control mr-2">
                                            <option value="">-- Tất cả --</option>
                                            <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>
                                                Nổi bật</option>
                                            <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>
                                                Thường</option>
                                        </select>

                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-filter mr-1"></i> Lọc
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-4 text-right">
                                    <select id="sort-by" class="form-control" onchange="sortProducts(this.value)">
                                        <option value="id-desc"
                                            {{ request('sortBy') == 'id' && request('orderBy') == 'desc' ? 'selected' : '' }}>
                                            Mới nhất</option>
                                        <option value="id-asc"
                                            {{ request('sortBy') == 'id' && request('orderBy') == 'asc' ? 'selected' : '' }}>
                                            Cũ nhất</option>
                                        <option value="name-asc"
                                            {{ request('sortBy') == 'name' && request('orderBy') == 'asc' ? 'selected' : '' }}>
                                            Tên A-Z</option>
                                        <option value="name-desc"
                                            {{ request('sortBy') == 'name' && request('orderBy') == 'desc' ? 'selected' : '' }}>
                                            Tên Z-A</option>
                                        <option value="price-asc"
                                            {{ request('sortBy') == 'price' && request('orderBy') == 'asc' ? 'selected' : '' }}>
                                            Giá tăng dần</option>
                                        <option value="price-desc"
                                            {{ request('sortBy') == 'price' && request('orderBy') == 'desc' ? 'selected' : '' }}>
                                            Giá giảm dần</option>
                                        <option value="quantity-asc"
                                            {{ request('sortBy') == 'quantity' && request('orderBy') == 'asc' ? 'selected' : '' }}>
                                            Số lượng tăng dần</option>
                                        <option value="quantity-desc"
                                            {{ request('sortBy') == 'quantity' && request('orderBy') == 'desc' ? 'selected' : '' }}>
                                            Số lượng giảm dần</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Statistics Row -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-box"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Tổng sản phẩm</span>
                                            <span class="info-box-number">{{ $products->total() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Đang bán</span>
                                            <span
                                                class="info-box-number">{{ $products->where('status', 'active')->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-star"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Nổi bật</span>
                                            <span
                                                class="info-box-number">{{ $products->where('is_featured', true)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i
                                                class="fas fa-exclamation-triangle"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Hết hàng</span>
                                            <span
                                                class="info-box-number">{{ $products->where('quantity', 0)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">
                                                <input type="checkbox" id="select-all">
                                            </th>
                                            <th style="width: 50px">ID</th>
                                            <th>Hình ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Danh mục</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Đánh giá</th>
                                            <th>Trạng thái</th>
                                            <th style="width: 120px">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="product-checkbox"
                                                        value="{{ $product->id }}">
                                                </td>
                                                <td>{{ $product->id }}</td>
                                                <td class="text-center">
                                                    @if ($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}"
                                                            alt="{{ $product->name }}" class="img-thumbnail"
                                                            style="max-height: 50px; max-width: 50px;">
                                                    @else
                                                        <span class="text-muted">
                                                            <i class="fas fa-image fa-2x"></i>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $product->name }}</strong>
                                                        @if ($product->jp_name)
                                                            <br><small class="text-muted">{{ $product->jp_name }}</small>
                                                        @endif
                                                        <div class="mt-1">
                                                            @if ($product->is_featured)
                                                                <button type="button"
                                                                    class="btn btn-xs btn-warning toggle-featured"
                                                                    data-id="{{ $product->id }}" data-featured="true"
                                                                    title="Click để bỏ nổi bật">
                                                                    <i class="fas fa-star"></i> Nổi bật
                                                                </button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-xs btn-outline-warning toggle-featured"
                                                                    data-id="{{ $product->id }}" data-featured="false"
                                                                    title="Click để đánh dấu nổi bật">
                                                                    <i class="far fa-star"></i> Thường
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($product->category)
                                                        <span
                                                            class="badge badge-info">{{ $product->category->name }}</span>
                                                    @else
                                                        <span class="text-muted">Không có</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="text-primary font-weight-bold">
                                                            {{ \App\Helpers\CurrencyHelper::formatPrice($product->price, $product->currency) }}
                                                        </span>
                                                <td>
                                                    @if ($product->quantity > 0)
                                                        <span class="badge badge-success">{{ $product->quantity }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $product->quantity }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-warning">{{ $product->rating_avg }}/5</span>
                                                    <br>
                                                    <small>({{ $product->rating_count }} đánh giá)</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-primary">{{ $product->status }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.products.show', $product->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                                            class="btn btn-sm btn-outline-info" title="Chỉnh sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="deleteProduct({{ $product->id }})" title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-box fa-3x mb-3"></i>
                                                        <p>Không có sản phẩm nào được tìm thấy</p>
                                                        <a href="{{ route('admin.products.create') }}"
                                                            class="btn btn-primary">
                                                            <i class="fas fa-plus mr-1"></i> Thêm sản phẩm đầu tiên
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Bulk Actions -->
                            @if ($products->count() > 0)
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="bulk-actions" style="display: none;">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="bulkUpdateStatus('active')">
                                                    <i class="fas fa-check mr-1"></i> Kích hoạt
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="bulkUpdateStatus('inactive')">
                                                    <i class="fas fa-times mr-1"></i> Vô hiệu hóa
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    onclick="bulkDelete()">
                                                    <i class="fas fa-trash mr-1"></i> Xóa đã chọn
                                                </button>
                                            </div>
                                            <span class="ml-2 text-muted">
                                                <span id="selected-count">0</span> sản phẩm được chọn
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $products->appends(request()->all())->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    <p>Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể khôi phục!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <form id="delete-form" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @forelse($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>
                <span class="text-primary font-weight-bold">
                    {{ \App\Helpers\CurrencyHelper::formatPrice($product->price, $product->currency ?? 'JPY') }}
                </span>
                <br><small class="text-muted">{{ $product->currency ?? 'JPY' }}</small>

                @if ($product->discount > 0)
                    <br>
                    <small class="text-muted">Giảm {{ $product->discount }}%</small>
                    <br>
                    <span class="text-success">
                        {{ \App\Helpers\CurrencyHelper::formatPrice($product->discounted_price, $product->currency ?? 'JPY') }}
                    </span>
                @endif
            </td>
            <td>
                <span class="badge {{ $product->quantity > 0 ? 'badge-success' : 'badge-danger' }}">
                    {{ number_format($product->quantity) }}
                </span>
                @if ($product->unit)
                    <br><small class="text-muted">{{ $product->unit->name }}</small>
                @endif
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="stars mr-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $product->rating_avg ? 'text-warning' : 'text-muted' }}"
                                style="font-size: 12px;"></i>
                        @endfor
                    </div>
                    <small class="text-muted">
                        {{ number_format($product->rating_avg, 1) }} ({{ $product->rating_count }})
                    </small>
                </div>
            </td>
            <td>
                @switch($product->status)
                    @case('active')
                        <button type="button" class="btn btn-sm btn-success toggle-status" data-id="{{ $product->id }}"
                            data-status="active" title="Click để vô hiệu hóa">
                            <i class="fas fa-check mr-1"></i> Kích hoạt
                        </button>
                    @break

                    @case('inactive')
                        <button type="button" class="btn btn-sm btn-danger toggle-status" data-id="{{ $product->id }}"
                            data-status="inactive" title="Click để kích hoạt">
                            <i class="fas fa-times mr-1"></i> Vô hiệu
                        </button>
                    @break

                    @default
                        <span class="badge badge-secondary">{{ $product->status }}</span>
                @endswitch
            </td>
            <td>
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary"
                        title="Xem chi tiết">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-info"
                        title="Chỉnh sửa">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="deleteProduct({{ $product->id }})" title="Xóa">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-box fa-3x mb-3"></i>
                        <p>Không có sản phẩm nào được tìm thấy</p>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Thêm sản phẩm đầu tiên
                        </a>
                    </div>
                </td>
            </tr>

        @endempty
    @endforelse
    <!-- Bulk Actions -->
    @if ($products->count() > 0)
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="bulk-actions" style="display: none;">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-success" onclick="bulkUpdateStatus('active')">
                            <i class="fas fa-check mr-1"></i> Kích hoạt
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="bulkUpdateStatus('inactive')">
                            <i class="fas fa-times mr-1"></i> Vô hiệu hóa
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" onclick="bulkDelete()">
                            <i class="fas fa-trash mr-1"></i> Xóa đã chọn
                        </button>
                    </div>
                    <span class="ml-2 text-muted">
                        <span id="selected-count">0</span> sản phẩm được chọn
                    </span>
                </div>
            </div>

            <div class="col-md-6">
                {{ $products->appends(request()->all())->links() }}
            </div>
        </div>
    @endif


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
                    <p>Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể khôi phục!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <form id="delete-form" method="POST" style="display: inline;">
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
        $(document).ready(function() {
            // Select all checkbox
            $('#select-all').change(function() {
                $('.product-checkbox').prop('checked', this.checked);
                updateBulkActions();
            });

            // Individual checkbox
            $('.product-checkbox').change(function() {
                updateBulkActions();
                updateSelectAll();
            });

            function updateBulkActions() {
                var checkedCount = $('.product-checkbox:checked').length;
                $('#selected-count').text(checkedCount);

                if (checkedCount > 0) {
                    $('.bulk-actions').show();
                } else {
                    $('.bulk-actions').hide();
                }
            }

            function updateSelectAll() {
                var totalCheckboxes = $('.product-checkbox').length;
                var checkedCheckboxes = $('.product-checkbox:checked').length;

                $('#select-all').prop('checked', totalCheckboxes === checkedCheckboxes);
            }
        });

        // Hàm sắp xếp sản phẩm
        function sortProducts(value) {
            const params = new URLSearchParams(window.location.search);
            const [sortBy, orderBy] = value.split('-');

            params.set('sortBy', sortBy);
            params.set('orderBy', orderBy);

            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }

        // Xóa sản phẩm
        function deleteProduct(id) {
            $('#delete-form').attr('action', `/admin/products/${id}`);
            $('#deleteModal').modal('show');
        }

        // Bulk update status
        function bulkUpdateStatus(status) {
            var selectedIds = $('.product-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm!');
                return;
            }

            if (confirm(
                    `Bạn có chắc muốn ${status === 'active' ? 'kích hoạt' : 'vô hiệu hóa'} ${selectedIds.length} sản phẩm đã chọn?`
                )) {
                $.ajax({
                    url: '{{ route('admin.products.bulk-update-status') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi cập nhật!');
                    }
                });
            }
        }

        // Bulk delete
        function bulkDelete() {
            var selectedIds = $('.product-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm!');
                return;
            }

            if (confirm(
                    `Bạn có chắc muốn xóa ${selectedIds.length} sản phẩm đã chọn? Hành động này không thể khôi phục!`)) {
                // Create a form to submit bulk delete
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('admin.products.bulk-delete') }}'
                });

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                }));

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_method',
                    'value': 'DELETE'
                }));

                selectedIds.forEach(function(id) {
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': 'ids[]',
                        'value': id
                    }));
                });

                $('body').append(form);
                form.submit();
            }
        }

        // Toggle status
        $(document).on('click', '.toggle-status', function() {
            var button = $(this);
            var productId = button.data('id');
            var currentStatus = button.data('status');

            button.prop('disabled', true);

            $.ajax({
                url: `{{ url('admin/products') }}/${productId}/toggle-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Update button
                        if (response.status === 'active') {
                            button.removeClass('btn-danger').addClass('btn-success')
                                .html('<i class="fas fa-check mr-1"></i> Kích hoạt')
                                .attr('title', 'Click để vô hiệu hóa')
                                .data('status', 'active');
                        } else {
                            button.removeClass('btn-success').addClass('btn-danger')
                                .html('<i class="fas fa-times mr-1"></i> Vô hiệu')
                                .attr('title', 'Click để kích hoạt')
                                .data('status', 'inactive');
                        }

                        // Show success message
                        showToast('success', response.message);
                    } else {
                        showToast('error', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'Có lỗi xảy ra khi cập nhật trạng thái!');
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });

        // Toggle featured
        $(document).on('click', '.toggle-featured', function() {
            var button = $(this);
            var productId = button.data('id');
            var currentFeatured = button.data('featured');

            button.prop('disabled', true);

            $.ajax({
                url: `{{ url('admin/products') }}/${productId}/toggle-featured`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Update button
                        if (response.is_featured) {
                            button.removeClass('btn-outline-warning').addClass('btn-warning')
                                .html('<i class="fas fa-star"></i> Nổi bật')
                                .attr('title', 'Click để bỏ nổi bật')
                                .data('featured', true);
                        } else {
                            button.removeClass('btn-warning').addClass('btn-outline-warning')
                                .html('<i class="far fa-star"></i> Thường')
                                .attr('title', 'Click để đánh dấu nổi bật')
                                .data('featured', false);
                        }

                        // Show success message
                        showToast('success', response.message);
                    } else {
                        showToast('error', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'Có lỗi xảy ra khi cập nhật trạng thái nổi bật!');
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });

        // Toast notification function
        function showToast(type, message) {
            // Simple toast implementation - you can replace with your preferred toast library
            var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            var toast = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                ${message}
            </div>
        `);

            $('body').append(toast);

            // Auto remove after 3 seconds
            setTimeout(function() {
                toast.fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        }
    </script>
@endpush;
@push('footer_js')
    <script>
        $(document).ready(function() {
            // Select all checkbox
            $('#select-all').change(function() {
                $('.product-checkbox').prop('checked', this.checked);
                updateBulkActions();
            });

            // Individual checkbox
            $('.product-checkbox').change(function() {
                updateBulkActions();
                updateSelectAll();
            });

            function updateBulkActions() {
                var checkedCount = $('.product-checkbox:checked').length;
                $('#selected-count').text(checkedCount);

                if (checkedCount > 0) {
                    $('.bulk-actions').show();
                } else {
                    $('.bulk-actions').hide();
                }
            }

            function updateSelectAll() {
                var totalCheckboxes = $('.product-checkbox').length;
                var checkedCheckboxes = $('.product-checkbox:checked').length;

                $('#select-all').prop('checked', totalCheckboxes === checkedCheckboxes);
            }
        });

        // Hàm sắp xếp sản phẩm
        function sortProducts(value) {
            const params = new URLSearchParams(window.location.search);
            const [sortBy, orderBy] = value.split('-');

            params.set('sortBy', sortBy);
            params.set('orderBy', orderBy);

            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }

        // Xóa sản phẩm
        function deleteProduct(id) {
            $('#delete-form').attr('action', `/admin/products/${id}`);
            $('#deleteModal').modal('show');
        }

        // Bulk update status
        function bulkUpdateStatus(status) {
            var selectedIds = $('.product-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm!');
                return;
            }

            if (confirm(
                    `Bạn có chắc muốn ${status === 'active' ? 'kích hoạt' : 'vô hiệu hóa'} ${selectedIds.length} sản phẩm đã chọn?`
                )) {
                $.ajax({
                    url: '{{ route('admin.products.bulk-update-status') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi cập nhật!');
                    }
                });
            }
        }

        // Bulk delete
        function bulkDelete() {
            var selectedIds = $('.product-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm!');
                return;
            }

            if (confirm(
                    `Bạn có chắc muốn xóa ${selectedIds.length} sản phẩm đã chọn? Hành động này không thể khôi phục!`)) {
                // Create a form to submit bulk delete
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('admin.products.bulk-delete') }}'
                });

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                }));

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_method',
                    'value': 'DELETE'
                }));

                selectedIds.forEach(function(id) {
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': 'ids[]',
                        'value': id
                    }));
                });

                $('body').append(form);
                form.submit();
            }
        }

        // Toggle status
        $(document).on('click', '.toggle-status', function() {
            var button = $(this);
            var productId = button.data('id');
            var currentStatus = button.data('status');

            button.prop('disabled', true);

            $.ajax({
                url: `{{ url('admin/products') }}/${productId}/toggle-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Update button
                        if (response.status === 'active') {
                            button.removeClass('btn-danger').addClass('btn-success')
                                .html('<i class="fas fa-check mr-1"></i> Kích hoạt')
                                .attr('title', 'Click để vô hiệu hóa')
                                .data('status', 'active');
                        } else {
                            button.removeClass('btn-success').addClass('btn-danger')
                                .html('<i class="fas fa-times mr-1"></i> Vô hiệu')
                                .attr('title', 'Click để kích hoạt')
                                .data('status', 'inactive');
                        }

                        // Show success message
                        showToast('success', response.message);
                    } else {
                        showToast('error', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'Có lỗi xảy ra khi cập nhật trạng thái!');
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });

        // Toggle featured
        $(document).on('click', '.toggle-featured', function() {
            var button = $(this);
            var productId = button.data('id');
            var currentFeatured = button.data('featured');

            button.prop('disabled', true);

            $.ajax({
                url: `{{ url('admin/products') }}/${productId}/toggle-featured`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Update button
                        if (response.is_featured) {
                            button.removeClass('btn-outline-warning').addClass('btn-warning')
                                .html('<i class="fas fa-star"></i> Nổi bật')
                                .attr('title', 'Click để bỏ nổi bật')
                                .data('featured', true);
                        } else {
                            button.removeClass('btn-warning').addClass('btn-outline-warning')
                                .html('<i class="far fa-star"></i> Thường')
                                .attr('title', 'Click để đánh dấu nổi bật')
                                .data('featured', false);
                        }

                        // Show success message
                        showToast('success', response.message);
                    } else {
                        showToast('error', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'Có lỗi xảy ra khi cập nhật trạng thái nổi bật!');
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });

        // Toast notification function
        function showToast(type, message) {
            // Simple toast implementation - you can replace with your preferred toast library
            var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            var toast = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                ${message}
            </div>
        `);

            $('body').append(toast);

            // Auto remove after 3 seconds
            setTimeout(function() {
                toast.fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        }
    </script>
@endpush
