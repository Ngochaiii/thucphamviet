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
                    <!-- Thêm/Sửa Đơn Vị -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ isset($unit) ? 'Chỉnh sửa đơn vị' : 'Thêm đơn vị mới' }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- form start -->
                        <form id="unitForm"
                            action="{{ isset($unit) ? route('admin.units.update', $unit->id) : route('admin.units.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($unit))
                                @method('PUT')
                            @endif

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Tên đơn vị <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Nhập tên đơn vị"
                                        value="{{ old('name', $unit->name ?? '') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="symbol">Ký hiệu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('symbol') is-invalid @enderror"
                                        id="symbol" name="symbol" placeholder="Nhập ký hiệu (vd: kg, m, cái)"
                                        value="{{ old('symbol', $unit->symbol ?? '') }}" required>
                                    @error('symbol')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        id="description" name="description" rows="3"
                                        placeholder="Nhập mô tả đơn vị">{{ old('description', $unit->description ?? '') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                            value="1"
                                            {{ old('is_active', $unit->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Kích hoạt</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($unit) ? 'Cập nhật' : 'Thêm mới' }}
                                </button>
                                <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">Hủy</a>
                                @if (isset($unit))
                                    <a href="{{ route('admin.units.create') }}"
                                        class="btn btn-success float-right">Thêm mới</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-7">
                    <!-- Danh sách Đơn Vị -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách đơn vị đo lường</h3>
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
                            <table class="table table-hover text-nowrap" id="unitsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">ID</th>
                                        <th>Tên đơn vị</th>
                                        <th>Ký hiệu</th>
                                        <th>Mô tả</th>
                                        <th style="width: 100px">Sản phẩm</th>
                                        <th style="width: 100px">Trạng thái</th>
                                        <th style="width: 120px">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($units as $unit)
                                        <tr>
                                            <td>{{ $unit->id }}</td>
                                            <td>
                                                <span class="font-weight-bold">{{ $unit->name }}</span>
                                            </td>
                                            <td>
                                                <code class="bg-light px-2 py-1 rounded">{{ $unit->symbol }}</code>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ Str::limit($unit->description, 50) ?: 'Chưa có mô tả' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $unit->products->count() }}</span>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input status-toggle"
                                                           id="status{{ $unit->id }}"
                                                           data-id="{{ $unit->id }}"
                                                           {{ $unit->is_active ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="status{{ $unit->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.units.edit', $unit->id) }}"
                                                        class="btn btn-sm btn-info" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.units.destroy', $unit->id) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete-btn"
                                                                title="Xóa" data-name="{{ $unit->name }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <br>Chưa có đơn vị nào
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $units->links() }}
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
                $('#unitsTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Status toggle
            $('.status-toggle').on('change', function() {
                var unitId = $(this).data('id');
                var isChecked = $(this).is(':checked');
                var switchElement = $(this);

                $.ajax({
                    url: '{{ route("admin.units.index") }}/' + unitId + '/toggle-status',
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
                var unitName = $(this).data('name');

                Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc muốn xóa đơn vị "' + unitName + '"?',
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
            $('#unitForm').on('submit', function(e) {
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
        });
    </script>
@endpush
