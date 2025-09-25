@extends('layouts.admin')

@section('title', 'Chi tiết mã giảm giá')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Chi tiết mã giảm giá: <code>{{ $coupon->code }}</code></h5>
                    <div>
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Thông tin cơ bản</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Mã giảm giá</label>
                                                <div class="fw-bold">
                                                    <code class="fs-5">{{ $coupon->code }}</code>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Loại giảm giá</label>
                                                <div class="fw-bold">
                                                    @if($coupon->type === 'percentage')
                                                        <span class="badge bg-info fs-6">Phần trăm</span>
                                                    @else
                                                        <span class="badge bg-success fs-6">Cố định</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Giá trị giảm</label>
                                                <div class="fw-bold fs-4 text-primary">
                                                    @if($coupon->type === 'percentage')
                                                        {{ $coupon->value }}%
                                                    @else
                                                        {{ number_format($coupon->value) }}đ
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Đơn hàng tối thiểu</label>
                                                <div class="fw-bold">
                                                    @if($coupon->minimum_order_amount)
                                                        {{ number_format($coupon->minimum_order_amount) }}đ
                                                    @else
                                                        <span class="text-muted">Không yêu cầu</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($coupon->description)
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Mô tả</label>
                                            <div class="border rounded p-3 bg-light">
                                                {{ $coupon->description }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Usage Limits -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Giới hạn sử dụng</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Giới hạn sử dụng tổng</label>
                                                <div class="fw-bold">
                                                    @if($coupon->usage_limit)
                                                        {{ $coupon->usage_limit }} lần
                                                    @else
                                                        <span class="text-muted">Không giới hạn</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Giới hạn mỗi người dùng</label>
                                                <div class="fw-bold">
                                                    @if($coupon->usage_limit_per_user)
                                                        {{ $coupon->usage_limit_per_user }} lần
                                                    @else
                                                        <span class="text-muted">Không giới hạn</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Đã sử dụng</label>
                                                <div class="fw-bold text-info">
                                                    {{ $coupon->used_count }} lần
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Còn lại</label>
                                                <div class="fw-bold">
                                                    @if($coupon->usage_limit)
                                                        {{ max(0, $coupon->usage_limit - $coupon->used_count) }} lần
                                                    @else
                                                        <span class="text-muted">Không giới hạn</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Time Period -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Thời gian hiệu lực</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Ngày bắt đầu</label>
                                                <div class="fw-bold">
                                                    {{ $coupon->starts_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Ngày kết thúc</label>
                                                <div class="fw-bold">
                                                    {{ $coupon->expires_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-muted">Thời gian còn lại</label>
                                        <div class="fw-bold">
                                            @if($coupon->isExpired())
                                                <span class="text-danger">Đã hết hạn</span>
                                            @else
                                                @php
                                                    $diff = now()->diff($coupon->expires_at);
                                                @endphp
                                                @if($diff->days > 0)
                                                    {{ $diff->days }} ngày
                                                @endif
                                                {{ $diff->h }} giờ {{ $diff->i }} phút
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Status Card -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Trạng thái</h6>
                                </div>
                                <div class="card-body text-center">
                                    @if($coupon->is_active)
                                        @if($coupon->isExpired())
                                            <span class="badge bg-warning fs-5 mb-3">Hết hạn</span>
                                        @elseif($coupon->isUsageLimitReached())
                                            <span class="badge bg-danger fs-5 mb-3">Hết lượt sử dụng</span>
                                        @else
                                            <span class="badge bg-success fs-5 mb-3">Đang hoạt động</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary fs-5 mb-3">Tạm dừng</span>
                                    @endif

                                    @if($coupon->usage_limit)
                                        <div class="progress mb-3">
                                            @php
                                                $percentage = min(100, ($coupon->used_count / $coupon->usage_limit) * 100);
                                            @endphp
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ $percentage }}%" 
                                                 aria-valuenow="{{ $percentage }}" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                                {{ round($percentage, 1) }}%
                                            </div>
                                        </div>
                                        <small class="text-muted">Tỷ lệ sử dụng</small>
                                    @endif
                                </div>
                            </div>

                            <!-- Metadata -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Thông tin khác</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Ngày tạo</label>
                                        <div class="fw-bold">{{ $coupon->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Cập nhật lần cuối</label>
                                        <div class="fw-bold">{{ $coupon->updated_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">ID</label>
                                        <div class="fw-bold">#{{ $coupon->id }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection