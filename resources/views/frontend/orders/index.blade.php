@extends('layouts.frontend')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
            </h1>
            <p class="text-muted mb-0">Quản lý và theo dõi tất cả đơn hàng của bạn</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="fas fa-shopping-cart"></i> Tiếp tục mua sắm
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="card mb-4">
        <div class="card-body">
            <ul class="nav nav-pills justify-content-center" id="orderTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-status="all" href="#all">
                        <i class="fas fa-list"></i> Tất cả 
                        <span class="badge bg-secondary ms-1">{{ $totalOrders ?? $orders->total() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-status="pending" href="#pending">
                        <i class="fas fa-clock"></i> Chờ xử lý
                        <span class="badge bg-warning ms-1">{{ $orderCounts['pending'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-status="processing" href="#processing">
                        <i class="fas fa-cog"></i> Đang xử lý
                        <span class="badge bg-info ms-1">{{ $orderCounts['processing'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-status="shipped" href="#shipped">
                        <i class="fas fa-truck"></i> Đang giao
                        <span class="badge bg-primary ms-1">{{ $orderCounts['shipped'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-status="delivered" href="#delivered">
                        <i class="fas fa-check-circle"></i> Đã giao
                        <span class="badge bg-success ms-1">{{ $orderCounts['delivered'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-status="cancelled" href="#cancelled">
                        <i class="fas fa-times-circle"></i> Đã hủy
                        <span class="badge bg-danger ms-1">{{ $orderCounts['cancelled'] ?? 0 }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
        <div id="ordersList">
            @foreach($orders as $order)
            <div class="card mb-3 order-item" data-status="{{ $order->status }}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">
                            <i class="fas fa-receipt"></i> 
                            Đơn hàng #{{ $order->order_number }}
                        </h6>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> 
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="text-end">
                        @switch($order->status)
                            @case('pending')
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock"></i> Chờ xử lý
                                </span>
                                @break
                            @case('processing')
                                <span class="badge bg-info">
                                    <i class="fas fa-cog"></i> Đang xử lý
                                </span>
                                @break
                            @case('shipped')
                                <span class="badge bg-primary">
                                    <i class="fas fa-truck"></i> Đang giao
                                </span>
                                @break
                            @case('delivered')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Đã giao
                                </span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle"></i> Đã hủy
                                </span>
                                @break
                        @endswitch
                        <div class="mt-1">
                            <small class="text-muted">
                                @switch($order->payment_method)
                                    @case('cod')
                                        <i class="fas fa-truck"></i> COD
                                        @break
                                    @case('bank_transfer')
                                        <i class="fas fa-university"></i> Chuyển khoản
                                        @break
                                    @case('qr_code')
                                        <i class="fas fa-qrcode"></i> QR Code
                                        @break
                                @endswitch
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Order Items Preview -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                @foreach($order->orderDetails->take(3) as $detail)
                                <div class="col-md-4 mb-2">
                                    <div class="d-flex align-items-center">
                                            @if($detail->book->image_url)
                                                <img src="{{ $detail->book->image_url }}" 
                                                 class="rounded me-2" 
                                                 alt="{{ $detail->book->title }}"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 small">{{ Str::limit($detail->book->title, 25) }}</h6>
                                            <small class="text-muted">x{{ $detail->quantity }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                                @if($order->orderDetails->count() > 3)
                                <div class="col-md-4 mb-2">
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="text-muted">
                                            <i class="fas fa-plus"></i> 
                                            {{ $order->orderDetails->count() - 3 }} sản phẩm khác
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="text-lg-end">
                                <div class="mb-2">
                                    <small class="text-muted">Tổng tiền:</small>
                                    <br>
                                                                    <div class="text-end">
                                    <span class="h5 text-danger mb-0">{{ number_format($order->final_amount ?? $order->total_amount) }}đ</span>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">{{ $order->orderDetails->count() }} sản phẩm</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if(in_array($order->status, ['pending', 'processing']))
                                <button class="btn btn-outline-danger btn-sm me-2" onclick="cancelOrder({{ $order->id }})">
                                    <i class="fas fa-times"></i> Hủy đơn hàng
                                </button>
                            @endif
                        </div>
                        
                        <div>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i> Xem chi tiết
                            </a>
                            
                            @if(in_array($order->status, ['pending', 'processing']))
                                <button class="btn btn-primary btn-sm ms-2" onclick="trackOrder({{ $order->id }})">
                                    <i class="fas fa-map-marker-alt"></i> Theo dõi
                                </button>
                            @endif
                            
                            @if($order->status == 'delivered')
                                <button class="btn btn-success btn-sm ms-2" onclick="reorder({{ $order->id }})">
                                    <i class="fas fa-redo"></i> Mua lại
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
        
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-bag text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-muted mb-3">Chưa có đơn hàng nào</h4>
            <p class="text-muted mb-4">
                Bạn chưa có đơn hàng nào. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Bắt đầu mua sắm
            </a>
        </div>
    @endif
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
                <p>Bạn có chắc chắn muốn hủy đơn hàng này không?</p>
                <p class="text-muted small">
                    <i class="fas fa-info-circle"></i> 
                    Đơn hàng đã hủy không thể khôi phục.
                </p>
                <div class="mb-3">
                    <label for="cancelReason" class="form-label">Lý do hủy (tùy chọn):</label>
                    <textarea class="form-control" id="cancelReason" rows="3" 
                              placeholder="Nhập lý do hủy đơn hàng..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Đóng
                </button>
                <button type="button" class="btn btn-danger" id="confirmCancel">
                    <i class="fas fa-check"></i> Xác nhận hủy
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

// Filter orders by status
$('#orderTabs .nav-link').on('click', function(e) {
    e.preventDefault();
    
    // Update active tab
    $('#orderTabs .nav-link').removeClass('active');
    $(this).addClass('active');
    
    const status = $(this).data('status');
    
    // Show/hide orders based on status
    if (status === 'all') {
        $('.order-item').show();
    } else {
        $('.order-item').hide();
        $(`.order-item[data-status="${status}"]`).show();
    }
});

// Cancel order function
let orderToCancel = null;

function cancelOrder(orderId) {
    orderToCancel = orderId;
    $('#cancelOrderModal').modal('show');
}

$('#confirmCancel').on('click', function() {
    if (!orderToCancel) return;
    
    const reason = $('#cancelReason').val();
    const button = $(this);
    
    button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
    
    $.ajax({
        url: `/orders/${orderToCancel}/cancel`,
        method: 'POST',
        data: { reason: reason },
        success: function(response) {
            if (response.success) {
                showAlert('success', 'Đơn hàng đã được hủy thành công');
                location.reload();
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
            button.prop('disabled', false).html('<i class="fas fa-check"></i> Xác nhận hủy');
            $('#cancelOrderModal').modal('hide');
            $('#cancelReason').val('');
            orderToCancel = null;
        }
    });
});

// Track order function
function trackOrder(orderId) {
    // This would typically open a tracking modal or redirect to tracking page
    showAlert('info', 'Tính năng theo dõi đơn hàng sẽ được cập nhật sớm!');
}

// Reorder function
function reorder(orderId) {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    
    $.ajax({
        url: `/orders/${orderId}/reorder`,
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
        },
        complete: function() {
            button.disabled = false;
            button.innerHTML = originalText;
        }
    });
}

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

// Update cart count in header
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
.nav-pills .nav-link {
    color: #6c757d;
    border-radius: 50px;
    margin: 0 5px;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background-color: #f8f9fa;
    color: #495057;
}

.nav-pills .nav-link.active {
    background-color: #0d6efd;
    color: white;
}

.order-item {
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.order-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.badge {
    font-size: 0.75em;
}

.btn-sm {
    font-size: 0.85rem;
    padding: 0.375rem 0.75rem;
}

@media (max-width: 768px) {
    .nav-pills {
        flex-direction: column;
    }
    
    .nav-pills .nav-link {
        margin: 2px 0;
        text-align: center;
    }
    
    .text-lg-end {
        text-align: center !important;
        margin-top: 1rem;
    }
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.text-danger {
    color: #dc3545 !important;
}
</style>
@endpush