@extends('layouts.admin')

@section('title', 'Chi tiết sách')
@section('page-title', 'Chi tiết sách: ' . $book->title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin chi tiết</h5>
                <div>
                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="200"><strong>Tên sách:</strong></td>
                                    <td>{{ $book->title }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tác giả:</strong></td>
                                    <td>{{ $book->author }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Danh mục:</strong></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $book->category->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Mô tả:</strong></td>
                                    <td>{{ $book->description ?: 'Chưa có mô tả' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>ISBN:</strong></td>
                                    <td>{{ $book->isbn ?: 'Chưa cập nhật' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Số trang:</strong></td>
                                    <td>{{ $book->pages ? number_format($book->pages) . ' trang' : 'Chưa cập nhật' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nhà xuất bản:</strong></td>
                                    <td>{{ $book->publisher ?: 'Chưa cập nhật' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Ngày xuất bản:</strong></td>
                                    <td>{{ $book->publish_date ? \Carbon\Carbon::parse($book->publish_date)->format('d/m/Y') : 'Chưa cập nhật' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Giá bán:</strong></td>
                                    <td>
                                        <span class="h5 text-danger">{{ number_format($book->price) }}đ</span>
                                        @if($book->sale_price && $book->sale_price < $book->price)
                                            <span class="text-muted text-decoration-line-through ms-2">{{ number_format($book->sale_price) }}đ</span>
                                            <span class="badge bg-success ms-2">
                                                Giảm {{ round((($book->price - $book->sale_price) / $book->price) * 100) }}%
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Số lượng kho:</strong></td>
                                    <td>
                                        <span class="badge {{ $book->stock_quantity > 10 ? 'bg-success' : ($book->stock_quantity > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ number_format($book->stock_quantity) }} cuốn
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Trạng thái:</strong></td>
                                    <td>
                                        @if($book->status)
                                            <span class="badge bg-success">Đang bán</span>
                                        @else
                                            <span class="badge bg-secondary">Ngừng bán</span>
                                        @endif
                                        
                                        @if($book->featured)
                                            <span class="badge bg-warning text-dark ms-2">Sách nổi bật</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Ngày tạo:</strong></td>
                                    <td>{{ $book->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cập nhật cuối:</strong></td>
                                    <td>{{ $book->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <div class="text-center">
                            @if($book->image)
                                <img src="{{ $book->image_url }}" alt="{{ $book->title }}" 
                                     class="img-fluid rounded shadow" style="max-width: 100%; max-height: 400px;">
                            @else
                                <div class="border rounded d-flex align-items-center justify-content-center" 
                                     style="height: 300px; background-color: #f8f9fa;">
                                    <div class="text-muted text-center">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <br>Chưa có ảnh bìa
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Statistics Row -->
                <div class="row mt-4">
                    <div class="col-12">
                        <hr>
                        <h6>Thống kê bán hàng</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-primary">{{ $book->orderDetails->count() }}</h5>
                                        <p class="card-text">Đơn hàng</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-success">{{ $book->orderDetails->sum('quantity') }}</h5>
                                        <p class="card-text">Đã bán</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-info">{{ number_format($book->orderDetails->sum('total_price')) }}đ</h5>
                                        <p class="card-text">Doanh thu</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-warning">{{ $book->carts->count() }}</h5>
                                        <p class="card-text">Trong giỏ hàng</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại danh sách
                            </a>
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Chỉnh sửa sách
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa sách</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sách <strong>"{{ $book->title }}"</strong> không?</p>
                <p class="text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Hành động này không thể hoàn tác!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa sách</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection