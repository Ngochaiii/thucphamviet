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
                                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
                                <li class="breadcrumb-item active">Chỉnh sửa: {{ $product->name }}</li>
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
                </div>

                <div class="col-md-9">
                    <!-- Form chỉnh sửa sản phẩm -->
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin cơ bản</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="jp_name">Tên tiếng Nhật</label>
                                    <input type="text" class="form-control @error('jp_name') is-invalid @enderror"
                                        id="jp_name" name="jp_name" value="{{ old('jp_name', $product->jp_name) }}">
                                    @error('jp_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name="slug" value="{{ old('slug', $product->slug) }}"
                                        placeholder="Tự động tạo nếu để trống">
                                    @error('slug')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                        name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="specification">Thông số kỹ thuật</label>
                                    <textarea class="form-control @error('specification') is-invalid @enderror" id="specification"
                                        name="specification" rows="5">{{ old('specification', $product->specification) }}</textarea>
                                    @error('specification')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Giá & Kho hàng</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="currency">Loại tiền tệ <span class="text-danger">*</span></label>
                                            <select class="form-control select2bs4 @error('currency') is-invalid @enderror"
                                                id="currency" name="currency" style="width: 100%;" required>
                                                @foreach ($currencies as $code => $name)
                                                    <option value="{{ $code }}"
                                                        {{ old('currency', $product->currency ?? 'JPY') == $code ? 'selected' : '' }}
                                                        data-symbol="{{ \App\Helpers\CurrencyHelper::getCurrencySymbol($code) }}"
                                                        data-position="{{ \App\Helpers\CurrencyHelper::getCurrencyInfo($code)['symbol_position'] }}">
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('currency')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="price">Giá bán <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend" id="currency-symbol-before" style="display: none;">
                                                    <span class="input-group-text" id="symbol-before">¥</span>
                                                </div>
                                                <input type="number"
                                                    class="form-control @error('price') is-invalid @enderror" id="price"
                                                    name="price" value="{{ old('price', $product->price) }}" min="0"
                                                    step="0.01" required>
                                                <div class="input-group-append" id="currency-symbol-after" style="display: none;">
                                                    <span class="input-group-text" id="symbol-after">₫</span>
                                                </div>
                                                @error('price')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="discount">Giảm giá (%)</label>
                                            <input type="number"
                                                class="form-control @error('discount') is-invalid @enderror"
                                                id="discount" name="discount" value="{{ old('discount', $product->discount ?? 0) }}"
                                                min="0" max="100" step="0.01">
                                            @error('discount')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Số lượng trong kho <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                                    @error('quantity')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Preview giá -->
                                <div class="alert alert-info" id="price-preview">
                                    <strong>Giá hiển thị:</strong> <span id="formatted-price">{{ \App\Helpers\CurrencyHelper::formatPrice($product->price, $product->currency ?? 'JPY') }}</span>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Phân loại & Trạng thái</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_id">Danh mục</label>
                                <select class="form-control select2bs4 @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" style="width: 100%;">
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="unit_id">Đơn vị</label>
                                <select class="form-control select2bs4 @error('unit_id') is-invalid @enderror"
                                    id="unit_id" name="unit_id" style="width: 100%;">
                                    <option value="">-- Chọn đơn vị --</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Trạng thái <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                                        Kích hoạt
                                    </option>
                                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                        Vô hiệu
                                    </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_featured"
                                        name="is_featured" value="1"
                                        {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_featured">Sản phẩm nổi bật</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Hình ảnh hiện tại -->
                            @if($product->image)
                                <div class="current-image mb-3">
                                    <label>Hình ảnh hiện tại:</label>
                                    <div class="text-center">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image"
                                            class="img-fluid img-thumbnail" style="max-height: 200px;">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="image">Hình ảnh chính {{ $product->image ? '(Thay đổi)' : '' }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input @error('image') is-invalid @enderror" id="image"
                                            name="image" accept="image/*">
                                        <label class="custom-file-label" for="image">Chọn file</label>
                                    </div>
                                </div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Hình ảnh phụ hiện tại -->
                            @if($product->images && count($product->images) > 0)
                                <div class="current-images mb-3">
                                    <label>Hình ảnh phụ hiện tại:</label>
                                    <div class="row">
                                        @foreach($product->images as $image)
                                            <div class="col-md-4 mb-2">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Current Additional Image"
                                                    class="img-fluid img-thumbnail" style="max-height: 150px;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="images">Hình ảnh phụ {{ ($product->images && count($product->images) > 0) ? '(Thay đổi)' : '' }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input @error('images') is-invalid @enderror" id="images"
                                            name="images[]" accept="image/*" multiple>
                                        <label class="custom-file-label" for="images">Chọn nhiều file</label>
                                    </div>
                                </div>
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Chọn hình ảnh mới sẽ thay thế toàn bộ hình ảnh phụ hiện tại</small>
                            </div>

                            <div class="preview-image mt-3 text-center" style="display: none;">
                                <img id="image-preview" src="#" alt="Xem trước hình ảnh"
                                    class="img-fluid img-thumbnail" style="max-height: 200px;">
                            </div>

                            <div class="preview-images mt-3" id="images-preview" style="display: none;">
                                <div class="row" id="images-container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save mr-1"></i> Cập nhật sản phẩm
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-times mr-1"></i> Hủy
                            </a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('footer_js')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        $(function() {
            // Select2
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            // Custom file input
            bsCustomFileInput.init();

            // Tự động tạo slug từ tên (chỉ khi slug trống hoặc giống tên cũ)
            var originalName = "{{ $product->name }}";
            var originalSlug = "{{ $product->slug }}";

            $('#name').on('input', function() {
                var currentSlug = $('#slug').val();
                // Chỉ tự động tạo slug mới nếu slug hiện tại trống hoặc giống với slug ban đầu
                if (!currentSlug || currentSlug === originalSlug) {
                    var name = $(this).val();
                    var slug = name.toLowerCase()
                        .replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a')
                        .replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e')
                        .replace(/ì|í|ị|ỉ|ĩ/g, 'i')
                        .replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o')
                        .replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u')
                        .replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y')
                        .replace(/đ/g, 'd')
                        .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng -
                        .replace(/[^\w\-]+/g, '') // Loại bỏ tất cả các ký tự không phải chữ
                        .replace(/\-\-+/g, '-') // Thay thế nhiều - bằng một -
                        .replace(/^-+/, '') // Cắt - từ đầu văn bản
                        .replace(/-+$/, ''); // Cắt - từ cuối văn bản

                    $('#slug').val(slug);
                }
            });

            // Xử lý thay đổi loại tiền tệ
            function updateCurrencyDisplay() {
                var selectedOption = $('#currency option:selected');
                var symbol = selectedOption.data('symbol');
                var position = selectedOption.data('position');

                // Ẩn tất cả symbol containers
                $('#currency-symbol-before, #currency-symbol-after').hide();

                // Hiển thị symbol ở vị trí phù hợp
                if (position === 'before') {
                    $('#symbol-before').text(symbol);
                    $('#currency-symbol-before').show();
                } else {
                    $('#symbol-after').text(symbol);
                    $('#currency-symbol-after').show();
                }

                // Cập nhật preview giá
                updatePricePreview();
            }

            // Cập nhật preview giá
            function updatePricePreview() {
                var price = parseFloat($('#price').val()) || 0;
                var currency = $('#currency').val();
                var discount = parseFloat($('#discount').val()) || 0;

                // Tính giá sau giảm giá
                var finalPrice = price;
                if (discount > 0) {
                    finalPrice = price - (price * discount / 100);
                }

                // Gọi API hoặc sử dụng JavaScript để format giá
                // Tạm thời sử dụng format đơn giản
                var selectedOption = $('#currency option:selected');
                var symbol = selectedOption.data('symbol');
                var position = selectedOption.data('position');

                var formattedPrice = '';
                if (position === 'before') {
                    formattedPrice = symbol + finalPrice.toLocaleString();
                } else {
                    formattedPrice = finalPrice.toLocaleString() + ' ' + symbol;
                }

                if (discount > 0) {
                    var originalFormatted = '';
                    if (position === 'before') {
                        originalFormatted = symbol + price.toLocaleString();
                    } else {
                        originalFormatted = price.toLocaleString() + ' ' + symbol;
                    }
                    $('#formatted-price').html('<del class="text-muted">' + originalFormatted + '</del> <strong class="text-success">' + formattedPrice + '</strong>');
                } else {
                    $('#formatted-price').text(formattedPrice);
                }
            }

            // Event listeners
            $('#currency').on('change', updateCurrencyDisplay);
            $('#price, #discount').on('input', updatePricePreview);

            // Khởi tạo ban đầu
            updateCurrencyDisplay();

            // Xem trước hình ảnh chính
            $("#image").change(function() {
                readURL(this, 'image-preview', '.preview-image');
            });

            // Xem trước nhiều hình ảnh
            $("#images").change(function() {
                readMultipleURL(this);
            });

            // CKEditor cho mô tả và thông số kỹ thuật
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('description');
                CKEDITOR.replace('specification');
            }
        });

        // Hàm xem trước hình ảnh đơn
        function readURL(input, previewId, containerClass) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result);
                    $(containerClass).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Hàm xem trước nhiều hình ảnh
        function readMultipleURL(input) {
            if (input.files) {
                var container = $('#images-container');
                container.empty();

                for (var i = 0; i < input.files.length; i++) {
                    (function(file, index) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var imgHtml = `
                                <div class="col-md-4 mb-2">
                                    <img src="${e.target.result}" class="img-fluid img-thumbnail" style="max-height: 150px;">
                                </div>
                            `;
                            container.append(imgHtml);
                        }
                        reader.readAsDataURL(file);
                    })(input.files[i], i);
                }

                $('#images-preview').show();
            }
        }
    </script>
@endpush
