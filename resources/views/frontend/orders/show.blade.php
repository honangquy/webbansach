@extends('layouts.frontend')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Đơn hàng của tôi</a></li>
            <li class="breadcrumb-item active">Chi tiết đơn hàng #{{ $order->order_number }}</li>
        </ol>
    </nav>

    <!-- Order Header -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="h3 mb-2">
                <i class="fas fa-receipt"></i> 
                Đơn hàng #{{ $order->order_number }}
            </h1>
            <p class="text-muted mb-0">
                Đặt ngày {{ $order->created_at->format('d/m/Y') }} lúc {{ $order->created_at->format('H:i') }}
            </p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="mb-2">
                @switch($order->status)
                    @case('pending')
                        <span class="badge bg-warning fs-6">
                            <i class="fas fa-clock"></i> Chờ xử lý
                        </span>
                        @break
                    @case('processing')
                        <span class="badge bg-info fs-6">
                            <i class="fas fa-cog"></i> Đang xử lý
                        </span>
                        @break
                    @case('shipped')
                        <span class="badge bg-primary fs-6">
                            <i class="fas fa-truck"></i> Đang giao
                        </span>
                        @break
                    @case('delivered')
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check-circle"></i> Đã giao
                        </span>
                        @break
                    @case('cancelled')
                        <span class="badge bg-danger fs-6">
                            <i class="fas fa-times-circle"></i> Đã hủy
                        </span>
                        @break
                @endswitch
            </div>
            <div>
                @if($order->status == 'pending')
                    <button class="btn btn-outline-danger btn-sm me-2" onclick="cancelOrder()">
                        <i class="fas fa-times"></i> Hủy đơn hàng
                    </button>
                @endif
                <button class="btn btn-outline-primary btn-sm" onclick="printOrder()">
                    <i class="fas fa-print"></i> In đơn hàng
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Sản phẩm đã đặt
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">Sản phẩm</th>
                                    <th class="border-0 text-center">Số lượng</th>
                                    <th class="border-0 text-end">Đơn giá</th>
                                    <th class="border-0 text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            @if($detail->book->image)
                                                    <img src="{{ $detail->book->image_url }}" 
                                                     class="rounded me-3" 
                                                     alt="{{ $detail->book->title }}"
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 80px; height: 80px;">
                                                    <i class="fas fa-book text-muted fs-4"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('books.show', $detail->book) }}" 
                                                       class="text-decoration-none">
                                                        {{ $detail->book->title }}
                                                    </a>
                                                </h6>
                                                <p class="text-muted mb-1 small">{{ $detail->book->author }}</p>
                                                <p class="text-muted mb-0 small">
                                                    <i class="fas fa-tag"></i> {{ $detail->book->category->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center align-middle">
                                        <span class="badge bg-secondary fs-6">{{ $detail->quantity }}</span>
                                    </td>
                                    <td class="py-3 text-end align-middle">
                                        {{ number_format($detail->price) }}đ
                                    </td>
                                    <td class="py-3 text-end align-middle">
                                        <strong class="text-danger">{{ number_format($detail->total) }}đ</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Lịch sử đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $order->status == 'pending' ? 'active' : 'completed' }}">
                            <div class="timeline-marker">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Đơn hàng đã được đặt</h6>
                                <p class="text-muted mb-0 small">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                            <div class="timeline-marker">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Đơn hàng đã được xác nhận</h6>
                                <p class="text-muted mb-0 small">
                                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                        {{ $order->updated_at->format('d/m/Y H:i') }}
                                    @else
                                        Đang chờ xác nhận
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '' }}">
                            <div class="timeline-marker">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Đơn hàng đang được giao</h6>
                                <p class="text-muted mb-0 small">
                                    @if(in_array($order->status, ['shipped', 'delivered']))
                                        Đã giao cho đơn vị vận chuyển
                                    @else
                                        Chờ giao hàng
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="timeline-item {{ $order->status == 'delivered' ? 'completed' : '' }}">
                            <div class="timeline-marker">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Đã giao hàng thành công</h6>
                                <p class="text-muted mb-0 small">
                                    @if($order->status == 'delivered')
                                        Đơn hàng đã được giao thành công
                                    @else
                                        Chờ giao hàng
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($order->notes)
            <!-- Order Notes -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-sticky-note"></i> Ghi chú đơn hàng
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
            
            @auth
                @if($order->status == 'delivered')
                <!-- Allow reviews only when order delivered -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-star text-warning"></i> Viết nhận xét cho sản phẩm </h6>
                    </div>
                    <div class="card-body">
                        @foreach($order->orderDetails as $detail)
                            @php
                                $already = \App\Models\Review::where('order_id', $order->id)
                                    ->where('book_id', $detail->book_id)
                                    ->where('user_id', auth()->id())
                                    ->exists();
                            @endphp

                            <div class="mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-3">
                                        <img src="{{ $detail->book->image_url }}" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:4px;">
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $detail->book->title }}</h6>
                                        <small class="text-muted">Số lượng: {{ $detail->quantity }}</small>
                                    </div>
                                </div>

                                @if($already)
                                    <div class="alert alert-secondary">Bạn đã đánh giá sản phẩm này cho đơn hàng này.</div>
                                @else
                                    <form method="POST" action="{{ route('orders.reviews.store', $order) }}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <input type="hidden" name="book_id" value="{{ $detail->book->id }}">

                                        <div class="mb-2">
                                            <label class="form-label fw-bold">Đánh giá:</label>
                                            <div class="star-select" data-target-input="rating-{{ $detail->book->id }}">
                                                @for($i=1;$i<=5;$i++)
                                                    <i class="far fa-star fa-2x star" data-value="{{ $i }}" style="cursor:pointer;color:#ccc;margin-right:6px;"></i>
                                                @endfor
                                            </div>
                                            <input type="hidden" id="rating-{{ $detail->book->id }}" name="rating" value="5">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Nhận xét (không bắt buộc)</label>
                                            <textarea name="comment" class="form-control" rows="3" placeholder="Viết nhận xét của bạn..."></textarea>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                            <a href="{{ route('books.show', $detail->book->id) }}" class="btn btn-outline-secondary">Xem sản phẩm</a>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endauth
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <!-- Order Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Thông tin đơn hàng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-6"><strong>Mã đơn hàng:</strong></div>
                        <div class="col-6 text-end">#{{ $order->order_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Ngày đặt:</strong></div>
                        <div class="col-6 text-end">{{ $order->created_at->format('d/m/Y') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Trạng thái:</strong></div>
                        <div class="col-6 text-end">
                            @switch($order->status)
                                @case('pending')
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                    @break
                                @case('processing')
                                    <span class="badge bg-info">Đang xử lý</span>
                                    @break
                                @case('shipped')
                                    <span class="badge bg-primary">Đang giao</span>
                                    @break
                                @case('delivered')
                                    <span class="badge bg-success">Đã giao</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"><strong>Thanh toán:</strong></div>
                        <div class="col-6 text-end">
                            @switch($order->payment_method)
                                @case('cod')
                                    <span class="text-muted small">
                                        <i class="fas fa-truck"></i> COD
                                    </span>
                                    @break
                                @case('qr_code')
                                    <span class="text-muted small">
                                        <i class="fas fa-qrcode"></i> QR Code
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-user"></i> Thông tin khách hàng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Họ tên:</strong><br>
                        {{ $order->customer_name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong><br>
                        <a href="mailto:{{ $order->customer_email }}" class="text-decoration-none">
                            {{ $order->customer_email }}
                        </a>
                    </div>
                    <div class="mb-3">
                        <strong>Số điện thoại:</strong><br>
                        <a href="tel:{{ $order->customer_phone }}" class="text-decoration-none">
                            {{ $order->customer_phone }}
                        </a>
                    </div>
                    <div>
                        <strong>Địa chỉ giao hàng:</strong><br>
                        {{ $order->shipping_address }}
                    </div>
                </div>
            </div>

            <!-- Order Total -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-calculator"></i> Tổng kết đơn hàng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($order->total_amount) }}đ</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Giảm giá:</span>
                        <span class="text-success">-{{ number_format($order->discount_amount) }}đ</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success">Miễn phí</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Thuế VAT:</span>
                        <span>Đã bao gồm</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Tổng cộng:</strong>
                        <strong class="text-danger fs-5">{{ number_format($order->final_amount ?? $order->total_amount) }}đ</strong>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-tools"></i> Thao tác nhanh
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($order->status == 'delivered')
                            <button class="btn btn-outline-success" onclick="reorder()">
                                <i class="fas fa-redo"></i> Đặt lại đơn hàng
                            </button>
                        @endif
                        
                        @if(in_array($order->status, ['pending', 'processing']))
                            <button class="btn btn-outline-primary" onclick="trackOrder()">
                                <i class="fas fa-map-marker-alt"></i> Theo dõi đơn hàng
                            </button>
                        @endif
                        
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning"></i> 
                    Xác nhận hủy đơn hàng
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng <strong>#{{ $order->order_number }}</strong> không?</p>
                <div class="mb-3">
                    <label for="cancelReason" class="form-label">Lý do hủy:</label>
                    <textarea class="form-control" id="cancelReason" rows="3" 
                              placeholder="Nhập lý do hủy đơn hàng..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Đóng
                </button>
                <button type="button" class="btn btn-danger" id="confirmCancel">
                    Xác nhận hủy
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// CSRF Token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Cancel order
function cancelOrder() {
    $('#cancelOrderModal').modal('show');
}

$('#confirmCancel').on('click', function() {
    const reason = $('#cancelReason').val();
    const button = $(this);
    
    button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
    
    $.ajax({
        url: `/orders/{{ $order->id }}/cancel`,
        method: 'POST',
        data: { reason: reason },
        success: function(response) {
            if (response.success) {
                showAlert('success', 'Đơn hàng đã được hủy thành công');
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(xhr) {
            let message = 'Có lỗi xảy ra, vui lòng thử lại!';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            showAlert('error', message);
        },
        complete: function() {
            button.prop('disabled', false).html('Xác nhận hủy');
            $('#cancelOrderModal').modal('hide');
        }
    });
});

// Print order
function printOrder() {
    window.print();
}

// Reorder
function reorder() {
    $.ajax({
        url: `/orders/{{ $order->id }}/reorder`,
        method: 'POST',
        success: function(response) {
            if (response.success) {
                showAlert('success', 'Đã thêm sản phẩm vào giỏ hàng');
                updateCartCount();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function() {
            showAlert('error', 'Có lỗi xảy ra, vui lòng thử lại!');
        }
    });
}

// Track order
function trackOrder() {
    showAlert('info', 'Tính năng theo dõi đơn hàng sẽ được cập nhật sớm!');
}

// star-select init (for review star pickers on this page)
$(document).ready(function() {
    $('.star-select').each(function() {
        const container = $(this);
        const target = $('#' + container.data('target-input'));
        container.find('.star').on('mouseenter', function() {
            const val = parseInt($(this).data('value'));
            container.find('.star').each(function() {
                const v = parseInt($(this).data('value'));
                $(this).toggleClass('far', v > val).toggleClass('fas', v <= val).css('color', v <= val ? '#ffc107' : '#ccc');
            });
        }).on('mouseleave', function() {
            const cur = parseInt(target.val());
            container.find('.star').each(function() {
                const v = parseInt($(this).data('value'));
                $(this).toggleClass('far', v > cur).toggleClass('fas', v <= cur).css('color', v <= cur ? '#ffc107' : '#ccc');
            });
        }).on('click', function() {
            const val = $(this).data('value');
            target.val(val);
        });
        container.trigger('mouseleave');
    });
});

// Show alert messages
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 'alert-info';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 10000; min-width: 300px;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
}

// Update cart count
function updateCartCount() {
    $.get('/cart/count', function(response) {
        if (response.count !== undefined) {
            $('#cartCount').text(response.count);
        }
    });
}
</script>
@endpush

@push('styles')
<style>
@media print {
    .btn, .card-header, nav, .modal {
        display: none !important;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
    
    .container {
        max-width: 100% !important;
        padding: 0 !important;
    }
}

.timeline {
    position: relative;
    padding: 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding: 0 0 20px 50px;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    border: 3px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 14px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-item.completed .timeline-marker {
    background: #198754;
    color: white;
}

.timeline-item.active .timeline-marker {
    background: #0d6efd;
    color: white;
}

.timeline-content h6 {
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.card {
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.badge {
    font-size: 0.75em;
}

.text-danger {
    color: #dc3545 !important;
}

@media (max-width: 768px) {
    .timeline::before {
        left: 15px;
    }
    
    .timeline-item {
        padding-left: 40px;
    }
    
    .timeline-marker {
        left: -25px;
        width: 30px;
        height: 30px;
        font-size: 12px;
    }
}
</style>
@endpush