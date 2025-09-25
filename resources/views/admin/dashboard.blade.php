@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng số sách</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $totalBooks ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-2 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Danh mục</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $totalCategories ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-3 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Đơn hàng</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $totalOrders ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Khách hàng</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $totalCustomers ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Recent Orders -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Đơn hàng gần đây</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">Xem tất cả</a>
            </div>
            <div class="card-body">
                @if(isset($recentOrders) && $recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ number_format($order->total_amount) }}đ</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning">Chờ xử lý</span>
                                        @elseif($order->status == 'confirmed')
                                            <span class="badge bg-info">Đã xác nhận</span>
                                        @elseif($order->status == 'shipping')
                                            <span class="badge bg-primary">Đang giao</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-success">Đã giao</span>
                                        @else
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Chưa có đơn hàng nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Low Stock Books -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sách sắp hết hàng</h6>
            </div>
            <div class="card-body">
                @if(isset($lowStockBooks) && $lowStockBooks->count() > 0)
                    @foreach($lowStockBooks as $book)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            @if($book->image)
                                <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $book->title }}</h6>
                            <small class="text-muted">{{ $book->author }}</small>
                            <div class="mt-1">
                                <span class="badge bg-danger">Còn {{ $book->stock_quantity }} cuốn</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="text-center">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-primary btn-sm">Xem tất cả sách</a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <p class="text-muted">Tất cả sách đều còn đủ hàng</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thao tác nhanh</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-plus"></i> Thêm sách mới
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-info w-100">
                            <i class="fas fa-plus"></i> Thêm danh mục
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-warning w-100">
                            <i class="fas fa-eye"></i> Xem đơn hàng
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-primary w-100">
                            <i class="fas fa-users"></i> Quản lý khách hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection