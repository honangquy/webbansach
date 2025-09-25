@extends('layouts.admin')

@section('title', 'Quản lý sách')
@section('page-title', 'Quản lý sách')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h4>Danh sách sách</h4>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm sách mới
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sách..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đang bán</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Ngừng bán</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Books Table -->
<div class="card">
    <div class="card-body">
        @if($books->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Tên sách</th>
                            <th>Tác giả</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Kho</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td>
                                @if($book->image)
                                    <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-book text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $book->title }}</strong>
                                @if($book->featured)
                                    <span class="badge bg-warning ms-1">Nổi bật</span>
                                @endif
                            </td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category->name ?? 'N/A' }}</td>
                            <td>
                                @if($book->sale_price)
                                    <span class="text-success fw-bold">{{ number_format($book->sale_price) }}đ</span><br>
                                    <small class="text-muted text-decoration-line-through">{{ number_format($book->price) }}đ</small>
                                @else
                                    <span class="fw-bold">{{ number_format($book->price) }}đ</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $book->stock_quantity <= 5 ? 'bg-danger' : 'bg-success' }}">
                                    {{ $book->stock_quantity }}
                                </span>
                            </td>
                            <td>
                                @if($book->status)
                                    <span class="badge bg-success">Đang bán</span>
                                @else
                                    <span class="badge bg-secondary">Ngừng bán</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-outline-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sách này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $books->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-book fa-5x text-muted mb-3"></i>
                <h5 class="text-muted">Chưa có sách nào</h5>
                <p class="text-muted">Hãy thêm sách đầu tiên để bắt đầu!</p>
                <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm sách mới
                </a>
            </div>
        @endif
    </div>
</div>
@endsection