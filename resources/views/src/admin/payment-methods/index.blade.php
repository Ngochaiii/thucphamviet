@extends('layouts.admin.index')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Thông báo -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-5">
                    <!-- Thêm/Sửa Phương Thức Thanh Toán -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ isset($paymentMethod) ? 'Chỉnh sửa phương thức' : 'Thêm phương thức mới' }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- form start -->
                        <form id="paymentMethodForm"
                            action="{{ isset($paymentMethod) ? route('admin.payment-methods.update', $paymentMethod->id) : route('admin.payment-methods.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($paymentMethod))
                                @method('PUT')
                            @endif

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type">Loại thanh toán <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Chọn loại thanh toán</option>
                                        <option value="credit_card" {{ old('type', $paymentMethod->type ?? '') == 'credit_card' ? 'selected' : '' }}>
                                            💳 Thẻ tín dụng
                                        </option>
                                        <option value="bank_transfer" {{ old('type', $paymentMethod->type ?? '') == 'bank_transfer' ? 'selected' : '' }}>
                                            🏦 Chuyển khoản ngân hàng
                                        </option>
                                        <option value="cash_on_delivery" {{ old('type', $paymentMethod->type ?? '') == 'cash_on_delivery' ? 'selected' : '' }}>
                                            💵 Thanh toán khi nhận hàng
                                        </option>
                                        <option value="e_wallet" {{ old('type', $paymentMethod->type ?? '') == 'e_wallet' ? 'selected' : '' }}>
                                            📱 Ví điện tử
                                        </option>
                                        <option value="cryptocurrency" {{ old('type', $paymentMethod->type ?? '') == 'cryptocurrency' ? 'selected' : '' }}>
                                            ₿ Tiền mã hóa
                                        </option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Tên phương thức <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Nhập tên phương thức"
                                        value="{{ old('name', $paymentMethod->name ?? '') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Ví dụ: Visa/Mastercard, VietComBank, PayPal</small>
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        id="description" name="description" rows="3"
                                        placeholder="Nhập mô tả phương thức thanh toán">{{ old('description', $paymentMethod->description ?? '') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="processing_fee">Phí xử lý (%) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('processing_fee') is-invalid @enderror"
                                            id="processing_fee" name="processing_fee" placeholder="0.00" step="0.01" min="0" max="100"
                                            value="{{ old('processing_fee', $paymentMethod->processing_fee ?? '') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        @error('processing_fee')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Phí xử lý tính theo % giá trị đơn hàng</small>
                                </div>

                                <div class="form-group">
                                    <label for="sort_order">Thứ tự hiển thị</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                        id="sort_order" name="sort_order" placeholder="0" min="0"
                                        value="{{ old('sort_order', $paymentMethod->sort_order ?? 0) }}">
                                    @error('sort_order')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Số thứ tự hiển thị (0 = đầu tiên)</small>
                                </div>

                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                            value="1"
                                            {{ old('is_active', $paymentMethod->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Kích hoạt</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($paymentMethod) ? 'Cập nhật' : 'Thêm mới' }}
                                </button>
                                <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">Hủy</a>
                                @if (isset($paymentMethod))
                                    <a href="{{ route('admin.payment-methods.create') }}"
                                        class="btn btn-success float-right">Thêm mới</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-7">
                    <!-- Danh sách Phương Thức Thanh Toán -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách phương thức thanh toán</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" id="searchInput" class="form-control float-right"
                                        placeholder="Tìm kiếm...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="paymentMethodsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">ID</th>
                                        <th>Loại</th>
                                        <th>Tên phương thức</th>
                                        <th>Phí (%)</th>
                                        <th>Thứ tự</th>
                                        <th style="width: 100px">Trạng thái</th>
                                        <th style="width: 120px">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paymentMethods as $method)
                                        <tr>
                                            <td>{{ $method->id }}</td>
                                            <td>
                                                @switch($method->type)
                                                    @case('credit_card')
                                                        <span class="badge badge-primary">💳 Thẻ tín dụng</span>
                                                        @break
                                                    @case('bank_transfer')
                                                        <span class="badge badge-info">🏦 Chuyển khoản</span>
                                                        @break
                                                    @case('cash_on_delivery')
                                                        <span class="badge badge-success">💵 COD</span>
                                                        @break
                                                    @case('e_wallet')
                                                        <span class="badge badge-warning">📱 Ví điện tử</span>
                                                        @break
                                                    @case('cryptocurrency')
                                                        <span class="badge badge-dark">₿ Crypto</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $method->name }}</span>
                                                @if($method->description)
                                                    <br><small class="text-muted">{{ Str::limit($method->description, 30) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="font-weight-bold text-danger">
                                                    {{ number_format($method->processing_fee, 2) }}%
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $method->sort_order }}</span>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input status-toggle"
                                                           id="status{{ $method->id }}"
                                                           data-id="{{ $method->id }}"
                                                           {{ $method->is_active ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="status{{ $method->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.payment-methods.edit', $method->id) }}"
                                                        class="btn btn-sm btn-info" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.payment-methods.destroy', $method->id) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete-btn"
                                                                title="Xóa" data-name="{{ $method->name }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <i class="fas fa-credit-card fa-2x mb-2"></i>
                                                <br>Chưa có phương thức thanh toán nào
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="float-right">
                                {{ $paymentMethods->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                            <div class="float-left">
                                <small class="text-muted">
                                    Hiển thị {{ $paymentMethods->firstItem() ?? 0 }} - {{ $paymentMethods->lastItem() ?? 0 }}
                                    trong tổng số {{ $paymentMethods->total() }} phương thức
                                </small>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@endsection

@push('footer_js')
    <script>
        $(function() {
            // Search functionality
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#paymentMethodsTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Status toggle
            $('.status-toggle').on('change', function() {
                var methodId = $(this).data('id');
                var isChecked = $(this).is(':checked');
                var switchElement = $(this);

                $.ajax({
                    url: '{{ route("admin.payment-methods.index") }}/' + methodId + '/toggle-status',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        }
                    },
                    error: function() {
                        // Revert the switch if error
                        switchElement.prop('checked', !isChecked);
                        toastr.error('Có lỗi xảy ra khi cập nhật trạng thái!');
                    }
                });
            });

            // Delete confirmation
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                var methodName = $(this).data('name');

                Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc muốn xóa phương thức "' + methodName + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Auto-hide alerts
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);

            // Form validation
            $('#paymentMethodForm').on('submit', function(e) {
                var type = $('#type').val();
                var name = $('#name').val().trim();
                var processingFee = $('#processing_fee').val();

                if (!type) {
                    e.preventDefault();
                    Swal.fire('Lỗi!', 'Vui lòng chọn loại thanh toán.', 'error');
                    $('#type').focus();
                    return false;
                }

                if (name.length < 2) {
                    e.preventDefault();
                    Swal.fire('Lỗi!', 'Tên phương thức phải có ít nhất 2 ký tự.', 'error');
                    $('#name').focus();
                    return false;
                }

                if (processingFee < 0 || processingFee > 100) {
                    e.preventDefault();
                    Swal.fire('Lỗi!', 'Phí xử lý phải từ 0% đến 100%.', 'error');
                    $('#processing_fee').focus();
                    return false;
                }
            });
        });
    </script>
@endpush
