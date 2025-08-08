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
                            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
                            <li class="breadcrumb-item active">Thêm danh mục mới</li>
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
                <!-- Form thêm danh mục -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-plus mr-2"></i>Thêm danh mục mới
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}"
                                       placeholder="Nhập tên danh mục..." required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                       id="slug" name="slug" value="{{ old('slug') }}"
                                       placeholder="Tự động tạo nếu để trống">
                                @error('slug')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">URL thân thiện cho danh mục này</small>
                            </div>

                            <div class="form-group">
                                <label for="parent_id">Danh mục cha</label>
                                <select class="form-control select2bs4 @error('parent_id') is-invalid @enderror"
                                        id="parent_id" name="parent_id">
                                    <option value="">-- Danh mục gốc --</option>
                                    @foreach($parentCategories as $parentCategory)
                                        <option value="{{ $parentCategory->id }}"
                                            {{ old('parent_id') == $parentCategory->id ? 'selected' : '' }}>
                                            {{ $parentCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Chọn danh mục cha nếu đây là danh mục con</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="4"
                                          placeholder="Nhập mô tả cho danh mục...">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">Hình ảnh danh mục</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                               id="image" name="image" accept="image/*">
                                        <label class="custom-file-label" for="image">Chọn file hình ảnh</label>
                                    </div>
                                </div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Định dạng: JPG, JPEG, PNG, GIF. Kích thước tối đa: 2MB</small>

                                <!-- Preview area -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                                    <button type="button" class="btn btn-sm btn-danger ml-2" id="removePreview">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sort_order">Thứ tự hiển thị</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                       id="sort_order" name="sort_order"
                                       value="{{ old('sort_order', 0) }}"
                                       min="0" step="1">
                                @error('sort_order')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Số thứ tự càng nhỏ sẽ hiển thị trước</small>
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
                                <small class="form-text text-muted">Danh mục chỉ hiển thị khi được kích hoạt</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Thêm danh mục
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo mr-2"></i>Làm mới
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-info float-right">
                                <i class="fas fa-list mr-2"></i>Danh sách danh mục
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
                            <p>Slug sẽ được tự động tạo từ tên danh mục. Bạn có thể chỉnh sửa slug để tối ưu SEO.</p>
                        </div>

                        <div class="callout callout-warning">
                            <h5><i class="fas fa-exclamation-triangle"></i> Lưu ý:</h5>
                            <ul class="mb-0">
                                <li>Tên danh mục là bắt buộc</li>
                                <li>Slug phải là duy nhất</li>
                                <li>Hình ảnh nên có tỉ lệ vuông (1:1)</li>
                                <li>Thứ tự hiển thị: số nhỏ hơn sẽ hiển thị trước</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Danh mục gần đây -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clock mr-2"></i>Danh mục gần đây
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    @forelse($parentCategories->take(5) as $recentCategory)
                                    <tr>
                                        <td>
                                            @if($recentCategory->image)
                                                <img src="{{ asset('storage/' . $recentCategory->image) }}"
                                                     alt="{{ $recentCategory->name }}"
                                                     class="img-circle" style="width: 25px; height: 25px;">
                                            @else
                                                <i class="fas fa-folder text-muted"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $recentCategory->name }}</strong>
                                            <br><small class="text-muted">{{ $recentCategory->children->count() }} danh mục con</small>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.categories.edit', $recentCategory->id) }}"
                                               class="btn btn-xs btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            <i class="fas fa-inbox"></i><br>
                                            Chưa có danh mục nào
                                        </td>
                                    </tr>
                                    @endforelse
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
        // Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: 'Chọn danh mục cha...'
        });

        // Custom file input
        bsCustomFileInput.init();

        // Auto-generate slug from name
        $('#name').on('input', function() {
            var name = $(this).val();
            if (name) {
                var slug = generateSlug(name);
                $('#slug').val(slug);
            }
        });

        // Function to generate Vietnamese-friendly slug
        function generateSlug(text) {
            return text.toLowerCase()
                .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
                .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
                .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
                .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
                .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
                .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
                .replace(/đ/gi, 'd')
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        }

        // Image preview functionality
        $('#image').on('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                // Validate file type
                if (!file.type.match('image.*')) {
                    Swal.fire('Lỗi!', 'Vui lòng chọn file hình ảnh!', 'error');
                    $(this).val('');
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire('Lỗi!', 'Kích thước file không được vượt quá 2MB!', 'error');
                    $(this).val('');
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove preview
        $('#removePreview').on('click', function() {
            $('#image').val('');
            $('.custom-file-label').html('Chọn file hình ảnh');
            $('#imagePreview').hide();
        });

        // Reset form
        $('button[type="reset"]').on('click', function() {
            // Reset select2
            $('#parent_id').val(null).trigger('change');
            // Hide image preview
            $('#imagePreview').hide();
            // Reset custom file input label
            $('.custom-file-label').html('Chọn file hình ảnh');
        });

        // Form validation
        $('form').on('submit', function(e) {
            var name = $('#name').val().trim();
            if (name.length < 2) {
                e.preventDefault();
                Swal.fire('Lỗi!', 'Tên danh mục phải có ít nhất 2 ký tự.', 'error');
                $('#name').focus();
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

        // Check for duplicate parameter (if coming from duplicate function)
        const urlParams = new URLSearchParams(window.location.search);
        const duplicateId = urlParams.get('duplicate');
        if (duplicateId) {
            // You can implement logic to pre-fill form with data from duplicated category
            Swal.fire('Thông báo', 'Đang tạo bản sao từ danh mục đã chọn...', 'info');
        }

        // Slug availability check (optional)
        $('#slug').on('blur', function() {
            var slug = $(this).val();
            if (slug) {
                // You can implement AJAX check for slug uniqueness here
                // Example:
                /*
                $.ajax({
                    url: '/admin/categories/check-slug',
                    data: { slug: slug },
                    success: function(response) {
                        if (!response.available) {
                            $('#slug').addClass('is-invalid');
                            // Show error message
                        }
                    }
                });
                */
            }
        });

        // Character counter for description
        $('#description').on('input', function() {
            var maxLength = 500; // Set your max length
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
