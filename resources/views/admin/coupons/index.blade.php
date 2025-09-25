@extends('layouts.admin')

@section('title', 'Quản lý Mã giảm giá')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách Mã giảm giá</h5>
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm mã giảm giá
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($coupons->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Mã</th>
                                        <th>Loại</th>
                                        <th>Giá trị</th>
                                        <th>Đơn tối thiểu</th>
                                        <th>Giới hạn sử dụng</th>
                                        <th>Đã sử dụng</th>
                                        <th>Thời gian hiệu lực</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coupons as $coupon)
                                        <tr>
                                            <td>
                                                <code>{{ $coupon->code }}</code>
                                            </td>
                                            <td>
                                                @if($coupon->type === 'percentage')
                                                    <span class="badge bg-info">Phần trăm</span>
                                                @else
                                                    <span class="badge bg-success">Cố định</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($coupon->type === 'percentage')
                                                    {{ $coupon->value }}%
                                                @else
                                                    {{ number_format($coupon->value) }}đ
                                                @endif
                                            </td>
                                            <td>
                                                @if($coupon->minimum_order_amount)
                                                    {{ number_format($coupon->minimum_order_amount) }}đ
                                                @else
                                                    Không
                                                @endif
                                            </td>
                                            <td>
                                                @if($coupon->usage_limit)
                                                    {{ $coupon->usage_limit }}
                                                @else
                                                    Không giới hạn
                                                @endif
                                            </td>
                                            <td>{{ $coupon->used_count }}</td>
                                            <td>
                                                <small>
                                                    Từ: {{ $coupon->starts_at->format('d/m/Y') }}<br>
                                                    Đến: {{ $coupon->expires_at->format('d/m/Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                @if($coupon->is_active)
                                                    @if($coupon->isExpired())
                                                        <span class="badge bg-warning">Hết hạn</span>
                                                    @elseif($coupon->isUsageLimitReached())
                                                        <span class="badge bg-danger">Hết lượt</span>
                                                    @else
                                                        <span class="badge bg-success">Hoạt động</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">Tạm dừng</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-outline-info" title="Xem">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-outline-primary" title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Xóa" 
                                                                onclick="return confirm('Bạn có chắc muốn xóa mã giảm giá này?')">
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
                        <div class="d-flex justify-content-center">
                            {{ $coupons->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có mã giảm giá nào</h5>
                            <p class="text-muted">Hãy tạo mã giảm giá đầu tiên để thu hút khách hàng!</p>
                            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tạo mã giảm giá
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection