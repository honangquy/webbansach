@extends('layouts.frontend')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Success Message -->
            <div class="text-center mb-4">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h1 class="h3 text-success mb-2">Đặt hàng thành công!</h1>
                <p class="text-muted mb-4">
                    Cảm ơn bạn đã đặt hàng. Chúng tôi đã nhận được đơn hàng của bạn và sẽ xử lý trong thời gian sớm nhất.
                </p>
            </div>

            <!-- Order Information -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt"></i> Thông tin đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Mã đơn hàng:</strong>
                            <br>
                            <span class="text-primary fs-5">#{{ $order->order_number }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Ngày đặt hàng:</strong>
                            <br>
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Trạng thái:</strong>
                            <br>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-clock"></i> {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Phương thức thanh toán:</strong>
                            <br>
                            @switch($order->payment_method)
                                @case('cod')
                                    <i class="fas fa-truck"></i> Thanh toán khi nhận hàng
                                    @break
                                @case('qr_code')
                                    <i class="fas fa-qrcode"></i> Thanh toán QR Code
                                    @break
                                @default
                                    {{ $order->payment_method }}
                            @endswitch
                        </div>
                        <div class="col-12">
                            <strong>Địa chỉ giao hàng:</strong>
                            <br>
                            {{ $order->shipping_address }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-list"></i> Chi tiết đơn hàng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="bg-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($detail->book->image)
                                                <img src="{{ $detail->book->image_url }}" 
                                                     class="rounded me-3" 
                                                     alt="{{ $detail->book->title }}"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $detail->book->title }}</h6>
                                                <small class="text-muted">{{ $detail->book->author }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-secondary">{{ $detail->quantity }}</span>
                                    </td>
                                    <td class="text-end align-middle">
                                        {{ number_format($detail->price) }}đ
                                    </td>
                                    <td class="text-end align-middle">
                                        <strong>{{ number_format($detail->total) }}đ</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th colspan="3" class="text-end">Tổng cộng:</th>
                                    <th class="text-end text-danger fs-5">
                                        {{ number_format($order->final_amount ?? $order->total_amount) }}đ
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Information (if applicable) -->
            @if($order->payment_method == 'qr_code')
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-qrcode"></i> Thanh toán QR Code
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=Payment for Order {{ $order->order_number }} - {{ number_format($order->final_amount ?? $order->total_amount) }}VND" 
                             alt="QR Code" class="img-fluid" style="max-width: 200px;">
                    </div>
                    <p class="text-muted">
                        Quét mã QR bằng ứng dụng ngân hàng của bạn để thanh toán
                    </p>
                    <div class="alert alert-info">
                        <strong>Số tiền:</strong> {{ number_format($order->final_amount ?? $order->total_amount) }}đ<br>
                        <strong>Mã đơn hàng:</strong> #{{ $order->order_number }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Next Steps -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Bước tiếp theo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-envelope text-primary"></i> Email xác nhận</h6>
                            <p class="small text-muted mb-3">
                                Chúng tôi đã gửi email xác nhận đến <strong>{{ $order->customer_email }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-truck text-success"></i> Giao hàng</h6>
                            <p class="small text-muted mb-3">
                                Đơn hàng sẽ được giao trong vòng 2-3 ngày làm việc
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-phone text-warning"></i> Hỗ trợ</h6>
                            <p class="small text-muted mb-3">
                                Liên hệ: <strong>19</strong> nếu cần hỗ trợ
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-history text-info"></i> Theo dõi đơn hàng</h6>
                            <p class="small text-muted mb-3">
                                Kiểm tra trạng thái đơn hàng trong tài khoản của bạn
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-eye"></i> Xem chi tiết đơn hàng
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-primary me-2">
                    <i class="fas fa-list"></i> Đơn hàng của tôi
                </a>
                <a href="{{ route('home') }}" class="btn btn-success">
                    <i class="fas fa-home"></i> Về trang chủ
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Confetti Animation -->
<div id="confetti-container"></div>
@endsection

@push('scripts')
<script>
// Simple confetti effect
$(document).ready(function() {
    createConfetti();
});

function createConfetti() {
    const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7', '#dda0dd'];
    const container = $('#confetti-container');
    
    for (let i = 0; i < 50; i++) {
        const confetti = $('<div></div>').css({
            position: 'fixed',
            width: '10px',
            height: '10px',
            backgroundColor: colors[Math.floor(Math.random() * colors.length)],
            left: Math.random() * 100 + 'vw',
            top: '-10px',
            zIndex: 9999,
            opacity: 0.8,
            borderRadius: '2px'
        });
        
        container.append(confetti);
        
        confetti.animate({
            top: '100vh',
            left: (Math.random() - 0.5) * 200 + 'px'
        }, {
            duration: Math.random() * 3000 + 2000,
            easing: 'linear',
            complete: function() {
                $(this).remove();
            }
        });
    }
}

// Print order function
function printOrder() {
    window.print();
}
</script>
@endpush

@push('styles')
<style>
@media print {
    .btn, .card-header, #confetti-container {
        display: none !important;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
}

.card {
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.table td, .table th {
    border-color: #f8f9fa;
}

.badge {
    font-size: 0.85em;
}

#confetti-container {
    pointer-events: none;
    overflow: hidden;
}

.text-success {
    color: #198754 !important;
}
</style>
@endpush