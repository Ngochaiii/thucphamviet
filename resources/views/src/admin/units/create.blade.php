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
                            <li class="breadcrumb-item active">Thêm đơn vị mới</li>
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
            </div>

            <div class="col-md-8">
                <!-- Form thêm đơn vị -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-plus mr-2"></i>Thêm đơn vị mới
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('admin.units.store') }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Tên đơn vị <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}"
                                       placeholder="Nhập tên đơn vị (vd: Kilogram, Mét, Cái)" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="symbol">Ký hiệu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('symbol') is-invalid @enderror"
                                       id="symbol" name="symbol" value="{{ old('symbol') }}"
                                       placeholder="Nhập ký hiệu (vd: kg, m, cái)" required>
                                @error('symbol')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Ký hiệu ngắn gọn để hiển thị cùng số lượng</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="4"
                                          placeholder="Nhập mô tả chi tiết về đơn vị...">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Trạng thái hoạt động</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                           value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">
                                        <span class="text-success">Kích hoạt</span> / <span class="text-danger">Vô hiệu hóa</span>
                                    </label>
                                </div>
                                <small class="form-text text-muted">Đơn vị chỉ hiển thị khi được kích hoạt</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Thêm đơn vị
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo mr-2"></i>Làm mới
                            </button>
                            <a href="{{ route('admin.units.index') }}" class="btn btn-info float-right">
                                <i class="fas fa-list mr-2"></i>Danh sách đơn vị
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Hướng dẫn -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>Hướng dẫn
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-lightbulb"></i> Mẹo:</h5>
                            <p>Tạo đơn vị với tên và ký hiệu dễ hiểu để quản lý sản phẩm hiệu quả hơn.</p>
                        </div>

                        <div class="callout callout-warning">
                            <h5><i class="fas fa-exclamation-triangle"></i> Lưu ý:</h5>
                            <ul class="mb-0">
                                <li>Tên đơn vị và ký hiệu là bắt buộc</li>
                                <li>Ký hiệu phải là duy nhất trong hệ thống</li>
                                <li>Nên sử dụng ký hiệu ngắn gọn (1-5 ký tự)</li>
                                <li>Mô tả giúp người dùng hiểu rõ hơn về đơn vị</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Ví dụ đơn vị -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-2"></i>Ví dụ đơn vị phổ biến
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tên đơn vị</th>
                                        <th>Ký hiệu</th>
                                        <th>Loại</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Kilogram</td>
                                        <td><code>kg</code></td>
                                        <td><small class="text-muted">Khối lượng</small></td>
                                    </tr>
                                    <tr>
                                        <td>Gram</td>
                                        <td><code>g</code></td>
                                        <td><small class="text-muted">Khối lượng</small></td>
                                    </tr>
                                    <tr>
                                        <td>Mét</td>
                                        <td><code>m</code></td>
                                        <td><small class="text-muted">Chiều dài</small></td>
                                    </tr>
                                    <tr>
                                        <td>Centimét</td>
                                        <td><code>cm</code></td>
                                        <td><small class="text-muted">Chiều dài</small></td>
                                    </tr>
                                    <tr>
                                        <td>Lít</td>
                                        <td><code>l</code></td>
                                        <td><small class="text-muted">Thể tích</small></td>
                                    </tr>
                                    <tr>
                                        <td>Cái</td>
                                        <td><code>cái</code></td>
                                        <td><small class="text-muted">Số lượng</small></td>
                                    </tr>
                                    <tr>
                                        <td>Hộp</td>
                                        <td><code>hộp</code></td>
                                        <td><small class="text-muted">Đóng gói</small></td>
                                    </tr>
                                    <tr>
                                        <td>Thùng</td>
                                        <td><code>thùng</code></td>
                                        <td><small class="text-muted">Đóng gói</small></td>
                                    </tr>
                                </tbody>
                            </table>
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
    $(function () {
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

            // Show loading
            var submitBtn = $(this).find('button[type="submit"]');
            var originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Đang xử lý...').prop('disabled', true);

            // Re-enable button after 10 seconds (fallback)
            setTimeout(function() {
                submitBtn.html(originalText).prop('disabled', false);
            }, 10000);
        });

        // Auto-hide alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

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

        // Auto-suggest symbol based on name
        $('#name').on('input', function() {
            var name = $(this).val().toLowerCase();
            var symbol = $('#symbol').val();

            // Only auto-suggest if symbol is empty
            if (!symbol) {
                var suggestions = {
                    'kilogram': 'kg',
                    'gram': 'g',
                    'mét': 'm',
                    'meter': 'm',
                    'centimét': 'cm',
                    'centimeter': 'cm',
                    'lít': 'l',
                    'liter': 'l',
                    'cái': 'cái',
                    'hộp': 'hộp',
                    'thùng': 'thùng',
                    'chai': 'chai',
                    'lon': 'lon',
                    'gói': 'gói',
                    'bao': 'bao'
                };

                for (var key in suggestions) {
                    if (name.includes(key)) {
                        $('#symbol').val(suggestions[key]);
                        break;
                    }
                }
            }
        });
    });
</script>
@endpush
