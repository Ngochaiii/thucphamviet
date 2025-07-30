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
                            <li class="breadcrumb-item active">Chỉnh sửa danh mục</li>
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
                <!-- Form chỉnh sửa danh mục -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit mr-2"></i>Chỉnh sửa danh mục: {{ $category->name }}
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                       id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
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
                                        @if($parentCategory->id != $category->id)
                                            <option value="{{ $parentCategory->id }}"
                                                {{ (old('parent_id', $category->parent_id) == $parentCategory->id) ? 'selected' : '' }}>
                                                {{ $parentCategory->name }}
                                            </option>
                                        @endif
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
                                          placeholder="Nhập mô tả cho danh mục...">{{ old('description', $category->description) }}</textarea>
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

                                @if($category->image)
                                <div class="mt-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                 alt="{{ $category->name }}"
                                                 class="img-thumbnail"
                                                 style="max-height: 150px; width: 100%; object-fit: cover;">
                                        </div>
                                        <div class="col-md-8">
                                            <p class="text-muted mb-1"><strong>Hình ảnh hiện tại</strong></p>
                                            <p class="text-sm text-muted">Tải lên ảnh mới nếu muốn thay thế.</p>
                                            <button type="button" class="btn btn-sm btn-danger" id="removeImage">
                                                <i class="fas fa-trash mr-1"></i>Xóa ảnh hiện tại
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <small class="form-text text-muted">Chưa có hình ảnh cho danh mục này</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="sort_order">Thứ tự hiển thị</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                       id="sort_order" name="sort_order"
                                       value="{{ old('sort_order', $category->sort_order) }}"
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
                                           value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">
                                        <span class="text-success">Kích hoạt</span> / <span class="text-danger">Vô hiệu hóa</span>
                                    </label>
                                </div>
                                <small class="form-text text-muted">Danh mục chỉ hiển thị khi được kích hoạt</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Cập nhật danh mục
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Quay lại
                            </a>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success float-right">
                                <i class="fas fa-plus mr-2"></i>Thêm danh mục mới
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Thông tin danh mục -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>Thông tin danh mục
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">ID:</dt>
                            <dd class="col-sm-8"><span class="badge badge-primary">{{ $category->id }}</span></dd>

                            <dt class="col-sm-4">Ngày tạo:</dt>
                            <dd class="col-sm-8">{{ $category->created_at->format('d/m/Y H:i') }}</dd>

                            <dt class="col-sm-4">Cập nhật:</dt>
                            <dd class="col-sm-8">{{ $category->updated_at->format('d/m/Y H:i') }}</dd>

                            <dt class="col-sm-4">Danh mục con:</dt>
                            <dd class="col-sm-8">
                                <span class="badge badge-info">{{ $category->children->count() }}</span>
                                @if($category->children->count() > 0)
                                    <small class="text-muted d-block">
                                        @foreach($category->children->take(3) as $child)
                                            • {{ $child->name }}<br>
                                        @endforeach
                                        @if($category->children->count() > 3)
                                            <em>và {{ $category->children->count() - 3 }} danh mục khác...</em>
                                        @endif
                                    </small>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Sản phẩm:</dt>
                            <dd class="col-sm-8">
                                <span class="badge badge-secondary">{{ $category->products->count() ?? 0 }}</span>
                            </dd>

                            <dt class="col-sm-4">Trạng thái:</dt>
                            <dd class="col-sm-8">
                                <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $category->is_active ? 'Hoạt động' : 'Vô hiệu' }}
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
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-block mb-2">
                                <i class="fas fa-plus mr-2"></i>Thêm danh mục mới
                            </a>

                            @if($category->parent)
                            <a href="{{ route('admin.categories.edit', $category->parent->id) }}"
                               class="btn btn-info btn-block mb-2">
                                <i class="fas fa-level-up-alt mr-2"></i>Sửa danh mục cha
                            </a>
                            @endif

                            <button type="button" class="btn btn-warning btn-block mb-2" id="duplicateCategory">
                                <i class="fas fa-copy mr-2"></i>Nhân bản danh mục
                            </button>
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

                        @if($category->children->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Lưu ý:</strong> Danh mục này có {{ $category->children->count() }} danh mục con.
                            Vui lòng xóa hoặc chuyển các danh mục con trước khi xóa.
                        </div>
                        @endif

                        @if($category->products->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Lưu ý:</strong> Danh mục này có {{ $category->products->count() }} sản phẩm.
                            Vui lòng chuyển các sản phẩm sang danh mục khác trước khi xóa.
                        </div>
                        @endif

                        <!-- Form xóa với xác nhận -->
                        <form id="deleteForm" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" id="deleteButton"
                                    {{ ($category->children->count() > 0 || $category->products->count() > 0) ? 'disabled' : '' }}>
                                <i class="fas fa-trash mr-2"></i>Xóa danh mục này vĩnh viễn
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
            var slug = generateSlug(name);
            $('#slug').val(slug);
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

        // Remove image functionality
        $('#removeImage').on('click', function() {
            Swal.fire({
                title: 'Xóa hình ảnh?',
                text: 'Bạn có chắc muốn xóa hình ảnh hiện tại?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Add hidden input to mark image for removal
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'remove_image',
                        value: '1'
                    }).appendTo('form');

                    // Hide the image preview
                    $(this).closest('.mt-3').hide();

                    Swal.fire('Đã xóa!', 'Hình ảnh sẽ được xóa khi bạn lưu thay đổi.', 'success');
                }
            });
        });

        // Duplicate category
        $('#duplicateCategory').on('click', function() {
            var currentName = $('#name').val();
            var newName = 'Bản sao - ' + currentName;

            Swal.fire({
                title: 'Nhân bản danh mục',
                text: 'Tạo danh mục mới với thông tin tương tự?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Tạo bản sao',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to create page with query parameters
                    var createUrl = '{{ route("admin.categories.create") }}' +
                        '?duplicate={{ $category->id }}';
                    window.location.href = createUrl;
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
                title: 'Xác nhận xóa danh mục',
                html: 'Bạn có chắc muốn xóa danh mục <strong>"{{ $category->name }}"</strong>?<br>' +
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
            if (name.length < 2) {
                e.preventDefault();
                Swal.fire('Lỗi!', 'Tên danh mục phải có ít nhất 2 ký tự.', 'error');
                $('#name').focus();
                return false;
            }
        });
    });
</script>
@endpush
