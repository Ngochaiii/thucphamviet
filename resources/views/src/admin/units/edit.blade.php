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
                            <li class="breadcrumb-item"><a href="{{ route('admin.units.index') }}">Đơn vị</a></li>
                            <li class="breadcrumb-item active">Chỉnh sửa đơn vị</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <!-- Thông báo lỗi -->
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Có lỗi xảy ra:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <!-- Thông báo thành công -->
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>

            <div class="col-md-8">
                <!-- Form chỉnh sửa đơn vị -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit mr-2"></i>Chỉnh sửa đơn vị: {{ $unit->name }}
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('admin.units.update', $unit->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Tên đơn vị <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $unit->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="symbol">Ký hiệu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('symbol') is-invalid @enderror"
                                       id="symbol" name="symbol" value="{{ old('symbol', $unit->symbol) }}" required>
                                @error('symbol')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Ký hiệu ngắn gọn để hiển thị cùng số lượng</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="4"
                                          placeholder="Nhập mô tả chi tiết về đơn vị...">{{ old('description', $unit->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Trạng thái hoạt động</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                           value="1" {{ old('is_active', $unit->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">
                                        <span class="text-success">Kích hoạt</span> / <span class="text-danger">Vô hiệu hóa</span>
                                    </label>
                                </div>
                                <small class="form-text text-muted">Đơn vị chỉ hiển thị khi được kích hoạt</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Cập nhật đơn vị
                            </button>
                            <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Quay lại
                            </a>
                            <a href="{{ route('admin.units.create') }}" class="btn btn-success float-right">
                                <i class="fas fa-plus mr-2"></i>Thêm đơn vị mới
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Thông tin đơn vị -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>Thông tin đơn vị
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">ID:</dt>
                            <dd class="col-sm-8"><span class="badge badge-primary">{{ $unit->id }}</span></dd>

                            <dt class="col-sm-4">Ký hiệu:</dt>
                            <dd class="col-sm-8"><code class="bg-light px-2 py-1 rounded">{{ $unit->symbol }}</code></dd>

                            <dt class="col-sm-4">Ngày tạo:</dt>
                            <dd class="col-sm-8">{{ $unit->created_at->format('d/m/Y H:i') }}</dd>

                            <dt class="col-sm-4">Cập nhật:</dt>
                            <dd class="col-sm-8">{{ $unit->updated_at->format('d/m/Y H:i') }}</dd>

                            <dt class="col-sm-4">Sản phẩm:</dt>
                            <dd class="col-sm-8">
                                <span class="badge badge-secondary">{{ $unit->products->count() }}</span>
                                @if($unit->products->count() > 0)
                                    <small class="text-muted d-block">
                                        @foreach($unit->products->take(3) as $product)
                                            • {{ $product->name }}<br>
                                        @endforeach
                                        @if($unit->products->count() > 3)
                                            <em>và {{ $unit->products->count() - 3 }} sản phẩm khác...</em>
                                        @endif
                                    </small>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Trạng thái:</dt>
                            <dd class="col-sm-8">
                                <span class="badge {{ $unit->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $unit->is_active ? 'Hoạt động' : 'Vô hiệu' }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                </div>

                <!-- Hành động nhanh -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tools mr-2"></i>Hành động nhanh
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.units.create') }}" class="btn btn-success btn-block mb-2">
                                <i class="fas fa-plus mr-2"></i>Thêm đơn vị mới
                            </a>

                            <button type="button" class="btn btn-warning btn-block mb-2" id="duplicateUnit">
                                <i class="fas fa-copy mr-2"></i>Nhân bản đơn vị
                            </button>

                            @if($unit->products->count() == 0)
                            <button type="button" class="btn btn-info btn-block mb-2" id="toggleStatus">
                                <i class="fas fa-toggle-{{ $unit->is_active ? 'on' : 'off' }} mr-2"></i>
                                {{ $unit->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }}
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Vùng nguy hiểm -->
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Vùng nguy hiểm
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-danger mb-3">
                            <i class="fas fa-warning mr-1"></i>
                            <strong>Cảnh báo:</strong> Các hành động dưới đây không thể khôi phục!
                        </p>

                        @if($unit->products->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Lưu ý:</strong> Đơn vị này đang được sử dụng bởi {{ $unit->products->count() }} sản phẩm.
                            Vui lòng chuyển các sản phẩm sang đơn vị khác trước khi xóa.
                        </div>
                        @endif

                        <!-- Form xóa với xác nhận -->
                        <form id="deleteForm" action="{{ route('admin.units.destroy', $unit->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" id="deleteButton"
                                    {{ $unit->products->count() > 0 ? 'disabled' : '' }}>
                                <i class="fas fa-trash mr-2"></i>Xóa đơn vị này vĩnh viễn
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('footer_js')
<script>
    $(function () {
        // Duplicate unit
        $('#duplicateUnit').on('click', function() {
            var currentName = $('#name').val();
            var newName = 'Bản sao - ' + currentName;

            Swal.fire({
                title: 'Nhân bản đơn vị',
                text: 'Tạo đơn vị mới với thông tin tương tự?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Tạo bản sao',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to create page with query parameters
                    var createUrl = '{{ route("admin.units.create") }}' +
                        '?duplicate={{ $unit->id }}';
                    window.location.href = createUrl;
                }
            });
        });

        // Toggle status
        $('#toggleStatus').on('click', function() {
            var currentStatus = {{ $unit->is_active ? 'true' : 'false' }};
            var action = currentStatus ? 'vô hiệu hóa' : 'kích hoạt';

            Swal.fire({
                title: 'Xác nhận thay đổi',
                text: 'Bạn có chắc muốn ' + action + ' đơn vị này?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.units.toggle-status", $unit->id) }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Thành công!', response.message, 'success')
                                    .then(() => {
                                        location.reload();
                                    });
                            }
                        },
                        error: function() {
                            Swal.fire('Lỗi!', 'Có lỗi xảy ra khi cập nhật trạng thái!', 'error');
                        }
                    });
                }
            });
        });

        // Delete confirmation
        $('#deleteButton').on('click', function(e) {
            e.preventDefault();

            if ($(this).is(':disabled')) {
                return false;
            }

            Swal.fire({
                title: 'Xác nhận xóa đơn vị',
                html: 'Bạn có chắc muốn xóa đơn vị <strong>"{{ $unit->name }}"</strong>?<br>' +
                      '<small class="text-danger">Hành động này không thể hoàn tác!</small>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa vĩnh viễn',
                cancelButtonText: 'Hủy bỏ',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm').submit();
                }
            });
        });

        // Auto-hide alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Form validation
        $('form').on('submit', function(e) {
            var name = $('#name').val().trim();
            var symbol = $('#symbol').val().trim();

            if (name.length < 2) {
                e.preventDefault();
                Swal.fire('Lỗi!', 'Tên đơn vị phải có ít nhất 2 ký tự.', 'error');
                $('#name').focus();
                return false;
            }

            if (symbol.length < 1) {
                e.preventDefault();
                Swal.fire('Lỗi!', 'Ký hiệu không được để trống.', 'error');
                $('#symbol').focus();
                return false;
            }
        });

        // Character counter for description
        $('#description').on('input', function() {
            var maxLength = 500;
            var currentLength = $(this).val().length;
            var remaining = maxLength - currentLength;

            if (!$('#char-counter').length) {
                $(this).after('<small id="char-counter" class="form-text text-muted"></small>');
            }

            $('#char-counter').text('Còn lại: ' + remaining + ' ký tự');

            if (remaining < 0) {
                $('#char-counter').removeClass('text-muted').addClass('text-danger');
            } else {
                $('#char-counter').removeClass('text-danger').addClass('text-muted');
            }
        });
    });
</script>
@endpush
