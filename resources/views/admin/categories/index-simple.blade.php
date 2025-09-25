@extends('layouts.admin-simple')

@section('title', 'Quản lý danh mục')
@section('page-title', 'Quản lý danh mục sách')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Danh sách danh mục</h4>
        <p class="text-muted mb-0">Quản lý các danh mục sách trong hệ thống</p>
    </div>
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm danh mục mới
    </a>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Mô tả</th>
                            <th>Số sách</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" 
                                             alt="{{ $category->name }}" 
                                             class="rounded me-2" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <strong>{{ $category->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">
                                    {{ Str::limit($category->description, 80) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $category->books_count }} sách</span>
                            </td>
                            <td>
                                @if($category->status)
                                    <span class="badge bg-success">Hiển thị</span>
                                @else
                                    <span class="badge bg-secondary">Ẩn</span>
                                @endif
                            </td>
                            <td>{{ $category->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="#" class="btn btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-warning" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Không có danh mục nào</h5>
                <p class="text-muted">Hãy thêm danh mục đầu tiên để bắt đầu.</p>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm danh mục mới
                </a>
            </div>
        @endif
    </div>
</div>
@endsection