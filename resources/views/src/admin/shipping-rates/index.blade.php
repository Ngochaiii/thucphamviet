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
                    <!-- Thêm/Sửa Vùng Ship -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ isset($shippingRate) ? 'Chỉnh sửa vùng ship' : 'Thêm vùng ship mới' }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- form start -->
                        <form id="shippingRateForm"
                            action="{{ isset($shippingRate) ? route('admin.shipping-rates.update', $shippingRate->id) : route('admin.shipping-rates.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($shippingRate))
                                @method('PUT')
                            @endif

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="province">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('province') is-invalid @enderror"
                                        id="province" name="province" placeholder="Nhập tỉnh/thành phố"
                                        value="{{ old('province', $shippingRate->province ?? '') }}" required>
                                    @error('province')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Ví dụ: Hà Nội, TP. Hồ Chí Minh, Đà Nẵng</small>
                                </div>

                                <div class="form-group">
                                    <label for="city">Quận/Huyện</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="city" name="city" placeholder="Nhập quận/huyện (tùy chọn)"
                                        value="{{ old('city', $shippingRate->city ?? '') }}">
                                    @error('city')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Để trống nếu áp dụng cho toàn tỉnh/thành phố</small>
                                </div>

                                <div class="form-group">
                                    <label for="zone_name">Tên vùng <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('zone_name') is-invalid @enderror"
                                        id="zone_name" name="zone_name" placeholder="Nhập tên vùng"
                                        value="{{ old('zone_name', $shippingRate->zone_name ?? '') }}" required>
                                    @error('zone_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Ví dụ: Nội thành, Ngoại thành, Miền Bắc, Miền Nam</small>
                                </div>

                                <div class="form-group">
                                    <label for="base_fee">Phí ship (¥) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">¥</span>
                                        </div>
                                        <input type="number" class="form-control @error('base_fee') is-invalid @enderror"
                                            id="base_fee" name="base_fee" placeholder="0.00" step="0.01" min="0"
                                            value="{{ old('base_fee', $shippingRate->base_fee ?? '') }}" required>
                                        @error('base_fee')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="delivery_days">Thời gian giao hàng (ngày) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('delivery_days') is-invalid @enderror"
                                        id="delivery_days" name="delivery_days" placeholder="Nhập số ngày" min="1" max="30"
                                        value="{{ old('delivery_days', $shippingRate->delivery_days ?? '') }}" required>
                                    @error('delivery_days')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Thời gian dự kiến giao hàng (1-30 ngày)</small>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($shippingRate) ? 'Cập nhật' : 'Thêm mới' }}
                                </button>
                                <a href="{{ route('admin.shipping-rates.index') }}" class="btn btn-secondary">Hủy</a>
                                @if (isset($shippingRate))
                                    <a href="{{ route('admin.shipping-rates.create') }}"
                                        class="btn btn-success float-right">Thêm mới</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-7">
                    <!-- Danh sách Vùng Ship -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách vùng ship</h3>
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
                            <table class="table table-hover text-nowrap" id="shippingRatesTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">ID</th>
                                        <th>Tỉnh/TP</th>
                                        <th>Quận/Huyện</th>
                                        <th>Tên vùng</th>
                                        <th>Phí ship</th>
                                        <th>Thời gian</th>
                                        <th style="width: 120px">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($shippingRates as $rate)
                                        <tr>
                                            <td>{{ $rate->id }}</td>
                                            <td>
                                                <span class="font-weight-bold">{{ $rate->province }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ $rate->city ?: 'Toàn tỉnh/TP' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $rate->zone_name }}</span>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold text-success">
                                                    {{ $rate->formatted_base_fee }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $rate->delivery_days }} ngày
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.shipping-rates.edit', $rate->id) }}"
                                                        class="btn btn-sm btn-info" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.shipping-rates.destroy', $rate->id) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete-btn"
                                                                title="Xóa" data-name="{{ $rate->full_location }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <i class="fas fa-shipping-fast fa-2x mb-2"></i>
                                                <br>Chưa có vùng ship nào
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $shippingRates->links() }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- Test Shipping Fee Card -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Kiểm tra phí ship</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="testShippingForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="test_province">Tỉnh/Thành phố</label>
                                            <input type="text" class="form-control" id="test_province"
                                                   placeholder="Nhập tỉnh/thành phố">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="test_city">Quận/Huyện</label>
                                            <input type="text" class="form-control" id="test_city"
                                                   placeholder="Nhập quận/huyện (tùy chọn)">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-calculator"></i> Tính phí ship
                                </button>
                            </form>
                            <div id="shippingResult" class="mt-3" style="display: none;">
                                <div class="alert alert-success">
                                    <h5><i class="fas fa-check"></i> Kết quả:</h5>
                                    <div id="resultContent"></div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                $('#shippingRatesTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Delete confirmation
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                var locationName = $(this).data('name');

                Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc muốn xóa vùng ship "' + locationName + '"?',
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
            $('#shippingRateForm').on('submit', function(e) {
                var province = $('#province').val().trim();
                var zoneName = $('#zone_name').val().trim();
                var baseFee = $('#base_fee').val();
                var deliveryDays = $('#delivery_days').val();

                if (province.length < 2) {
                    e.preventDefault();
                    Swal.fire('Lỗi!', 'Tỉnh/Thành phố phải có ít nhất 2 ký tự.', 'error');
                    $('#province').focus();
                    return false;
                }

                if (zoneName.length < 2) {
                    e.preventDefault();
                    Swal.fire('Lỗi!', 'Tên vùng phải có ít nhất 2 ký tự.', 'error');
                    $('#zone_name').focus();
                    return false;
                }

                if (baseFee <= 0) {
                    e.preventDefault();
                    Swal.fire('Lỗi!', 'Phí ship phải lớn hơn 0.', 'error');
                    $('#base_fee').focus();
                    return false;
                }

                if (deliveryDays < 1 || deliveryDays > 30) {
                    e.preventDefault();
                    Swal.fire('Lỗi!', 'Thời gian giao hàng phải từ 1 đến 30 ngày.', 'error');
                    $('#delivery_days').focus();
                    return false;
                }
            });

            // Test shipping fee
            $('#testShippingForm').on('submit', function(e) {
                e.preventDefault();
                var province = $('#test_province').val().trim();
                var city = $('#test_city').val().trim();

                if (!province) {
                    Swal.fire('Lỗi!', 'Vui lòng nhập tỉnh/thành phố.', 'error');
                    return;
                }

                $.ajax({
                    url: '{{ route("admin.shipping-rates.calculate-fee") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        province: province,
                        city: city
                    },
                    success: function(response) {
                        if (response.success) {
                            var content = '<ul class="mb-0">';
                            content += '<li><strong>Vùng:</strong> ' + response.zone_name + '</li>';
                            content += '<li><strong>Phí ship:</strong> ¥ ' + parseFloat(response.fee).toLocaleString() + '</li>';
                            content += '<li><strong>Thời gian giao hàng:</strong> ' + response.delivery_days + ' ngày</li>';
                            content += '</ul>';

                            $('#resultContent').html(content);
                            $('#shippingResult').show();
                            $('#shippingResult .alert').removeClass('alert-danger').addClass('alert-success');
                            $('#shippingResult h5 i').removeClass('fa-exclamation-triangle').addClass('fa-check');
                        } else {
                            $('#resultContent').html('<p class="mb-0">' + response.message + '</p>');
                            $('#shippingResult').show();
                            $('#shippingResult .alert').removeClass('alert-success').addClass('alert-danger');
                            $('#shippingResult h5 i').removeClass('fa-check').addClass('fa-exclamation-triangle');
                        }
                    },
                    error: function() {
                        Swal.fire('Lỗi!', 'Có lỗi xảy ra khi tính phí ship.', 'error');
                    }
                });
            });

            // Auto-format number inputs
            $('#base_fee').on('input', function() {
                var value = $(this).val();
                if (value && !isNaN(value)) {
                    $(this).val(parseFloat(value).toFixed(2));
                }
            });
        });
    </script>
@endpush
