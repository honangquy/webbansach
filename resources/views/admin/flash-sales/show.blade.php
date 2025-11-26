@extends('layouts.admin')

@section('title', 'Chi tiết Flash Sale')

@section('page-title', 'Chi tiết Flash Sale')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.flash-sales.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
    </a>
    <a href="{{ route('admin.flash-sales.edit', $flashSale->id) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Chỉnh sửa
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Thông tin Flash Sale</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">Tiêu đề</th>
                        <td>{{ $flashSale->title }}</td>
                    </tr>
                    <tr>
                        <th>Mô tả</th>
                        <td>{{ $flashSale->description ?? 'Không có' }}</td>
                    </tr>
                    <tr>
                        <th>Thời gian bắt đầu</th>
                        <td>{{ $flashSale->start_time->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Thời gian kết thúc</th>
                        <td>{{ $flashSale->end_time->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            <span class="badge {{ $flashSale->status ? 'bg-success' : 'bg-secondary' }}">
                                {{ $flashSale->status ? 'Bật' : 'Tắt' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tình trạng</th>
                        <td>
                            @if($flashSale->hasEnded())
                                <span class="badge bg-secondary">Đã kết thúc</span>
                            @elseif($flashSale->isActive())
                                <span class="badge bg-success">Đang diễn ra</span>
                            @elseif(!$flashSale->hasStarted())
                                <span class="badge bg-warning">Sắp diễn ra</span>
                            @else
                                <span class="badge bg-secondary">Không hoạt động</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Thống kê</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-muted">Số sản phẩm</h6>
                    <h3>{{ $flashSale->items->count() }}</h3>
                </div>
                <div class="mb-3">
                    <h6 class="text-muted">Tổng số lượng</h6>
                    <h3>{{ $flashSale->items->sum('stock_quantity') }}</h3>
                </div>
                <div class="mb-3">
                    <h6 class="text-muted">Đã bán</h6>
                    <h3>{{ $flashSale->items->sum('sold_quantity') }}</h3>
                </div>
                <div>
                    <h6 class="text-muted">Còn lại</h6>
                    <h3>{{ $flashSale->items->sum('stock_quantity') - $flashSale->items->sum('sold_quantity') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Danh sách sản phẩm</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hình ảnh</th>
                        <th>Tên sách</th>
                        <th>Giá gốc</th>
                        <th>Giá Flash Sale</th>
                        <th>Giảm giá</th>
                        <th>Số lượng</th>
                        <th>Đã bán</th>
                        <th>Còn lại</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($flashSale->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->book->image)
                                <img src="{{ $item->book->image_url }}" 
                                     alt="{{ $item->book->title }}" 
                                     style="width: 50px; height: 70px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 70px;">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $item->book->title }}</strong><br>
                            <small class="text-muted">{{ $item->book->author }}</small>
                        </td>
                        <td>{{ number_format($item->book->price) }}đ</td>
                        <td><strong class="text-danger">{{ number_format($item->flash_price) }}đ</strong></td>
                        <td>
                            <span class="badge bg-danger">-{{ $item->discount_percent }}%</span>
                        </td>
                        <td>{{ $item->stock_quantity }}</td>
                        <td>{{ $item->sold_quantity }}</td>
                        <td>
                            <span class="badge {{ $item->remaining_stock > 0 ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->remaining_stock }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
