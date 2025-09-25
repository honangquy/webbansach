@extends('layouts.admin')

@section('title', 'Chỉnh sửa danh mục')
@section('page-title', 'Chỉnh sửa danh mục: ' . $category->name)

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin danh mục</h5>
                <div>
                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Xem chi tiết
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $category->name) }}" required
                               placeholder="Nhập tên danh mục...">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Tên danh mục phải là duy nhất trong hệ thống.</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4"
                                  placeholder="Nhập mô tả về danh mục (tùy chọn)...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Mô tả giúp khách hàng hiểu rõ hơn về danh mục sách này.</div>
                    </div>

                    <!-- Category Statistics -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Thông tin danh mục</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small><strong>Số sách:</strong> {{ $category->books->count() }} cuốn</small>
                            </div>
                            <div class="col-md-6">
                                <small><strong>Ngày tạo:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <div>
                            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-info me-2">
                                <i class="fas fa-eye"></i> Xem chi tiết
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection