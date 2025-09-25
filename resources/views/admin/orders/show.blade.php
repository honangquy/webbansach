@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number)

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Chi tiết đơn hàng #{{ $order->order_number }}</h1>
            <small class="text-muted">Thông tin chi tiết và trạng thái đơn hàng</small>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <button class="btn btn-outline-primary" onclick="printOrder()">
                <i class="fas fa-print"></i> In đơn hàng
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-xl-8">
            <!-- Order Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin đơn hàng</h6>
                    <div>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge bg-warning fs-6">Chờ xử lý</span>
                                @break
                            @case('processing')
                                <span class="badge bg-info fs-6">Đang xử lý</span>
                                @break
                            @case('shipped')
                                <span class="badge bg-primary fs-6">Đang giao</span>
                                @break
                            @case('delivered')
                                <span class="badge bg-success fs-6">Đã giao</span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger fs-6">Đã hủy</span>
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <h6 class="text-muted mb-2">Thông tin cơ bản</h6>
                                <div class="info-item">
                                    <strong>Mã đơn hàng:</strong>
                                    <span>#{{ $order->order_number }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Ngày đặt hàng:</strong>
                                    <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Phương thức thanh toán:</strong>
                                    <span>{{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản' }}</span>
                                </div>
                                {{-- Only show payment status when order is paid. Removed 'Chưa thanh toán' badge per request. --}}
                                @if($order->payment_status === 'paid')
                                <div class="info-item">
                                    <strong>Trạng thái thanh toán:</strong>
                                    <span class="badge bg-success">Đã thanh toán</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <h6 class="text-muted mb-2">Thông tin giao hàng</h6>
                                <div class="info-item">
                                    <strong>Tên người nhận:</strong>
                                    <span>{{ $order->shipping_name }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Số điện thoại:</strong>
                                    <span>{{ $order->shipping_phone }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Địa chỉ giao hàng:</strong>
                                    <span>{{ $order->shipping_address }}</span>
                                </div>
                                @if($order->notes)
                                <div class="info-item">
                                    <strong>Ghi chú:</strong>
                                    <span>{{ $order->notes }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sản phẩm đã đặt</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($detail->book && $detail->book->image)
                                                <img src="{{ $detail->book->image_url }}" 
                                                 alt="{{ $detail->book_title }}" 
                                                 class="me-3" 
                                                 style="width: 50px; height: 70px; object-fit: cover;">
                                            @else
                                            <div class="bg-light me-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 70px;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <strong>{{ $detail->book_title }}</strong><br>
                                                @if($detail->book)
                                                <small class="text-muted">
                                                    <a href="{{ route('admin.books.show', $detail->book) }}" class="text-decoration-none">
                                                        Xem sách
                                                    </a>
                                                </small>
                                                @else
                                                <small class="text-danger">Sản phẩm đã bị xóa</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ number_format($detail->price) }}đ</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td><strong>{{ number_format($detail->price * $detail->quantity) }}đ</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Tổng cộng:</th>
                                    <th><strong class="text-success">{{ number_format($order->final_amount ?? $order->total_amount) }}đ</strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order History -->
            @if(false) {{-- Tạm thời ẩn phần Order History --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lịch sử đơn hàng</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($orderHistory as $history)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $history->status_text }}</h6>
                                <p class="text-muted mb-1">{{ $history->notes }}</p>
                                <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif {{-- Kết thúc phần Order History tạm thời ẩn --}}
        </div>

        <!-- Sidebar -->
        <div class="col-xl-4">
            <!-- Customer Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin khách hàng</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-lg mx-auto mb-2">
                            <div class="avatar-initial bg-label-primary rounded-circle" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                        </div>
                        <h6 class="mb-1">{{ $order->user->name }}</h6>
                        <p class="text-muted mb-0">{{ $order->user->email }}</p>
                    </div>

                    <div class="customer-stats">
                        <div class="stat-item">
                            <strong>Tổng đơn hàng:</strong>
                            <span class="float-end">{{ $order->user->orders_count ?? 0 }}</span>
                        </div>
                        <div class="stat-item">
                            <strong>Tổng chi tiêu:</strong>
                            <span class="float-end text-success">{{ number_format($order->user->orders_sum_total_amount ?? 0) }}đ</span>
                        </div>
                        <div class="stat-item">
                            <strong>Ngày đăng ký:</strong>
                            <span class="float-end">{{ $order->user->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="d-grid mt-3">
                        <a href="{{ route('admin.customers.show', $order->user) }}" class="btn btn-outline-primary">
                            <i class="fas fa-user"></i> Xem hồ sơ khách hàng
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cập nhật trạng thái</h6>
                </div>
                <div class="card-body">
                    <form id="statusUpdateForm">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái đơn hàng</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Đang giao</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú (tùy chọn)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                      placeholder="Nhập ghi chú về thay đổi trạng thái..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary" onclick="updateOrderStatus()">
                                <i class="fas fa-save"></i> Cập nhật trạng thái
                            </button>
                        </div>
                    </form>

                    <hr>

                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-info" onclick="printOrder()">
                            <i class="fas fa-print"></i> In đơn hàng
                        </button>
                        
                        @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                        <button class="btn btn-outline-warning" onclick="sendNotification()">
                            <i class="fas fa-envelope"></i> Gửi thông báo
                        </button>
                        @endif

                        @if($order->status === 'pending')
                        <button class="btn btn-outline-danger" onclick="cancelOrder()">
                            <i class="fas fa-times"></i> Hủy đơn hàng
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <strong>Số sản phẩm:</strong>
                        <span class="float-end">{{ $order->orderDetails->sum('quantity') }}</span>
                    </div>
                    <div class="stat-item">
                        <strong>Loại sản phẩm:</strong>
                        <span class="float-end">{{ $order->orderDetails->count() }}</span>
                    </div>
                    <div class="stat-item">
                        <strong>Giá trị đơn hàng:</strong>
                        <span class="float-end text-success">{{ number_format($order->total_amount) }}đ</span>
                    </div>
                    <div class="stat-item">
                        <strong>Thời gian xử lý:</strong>
                        <span class="float-end">
                            @if($order->status === 'delivered')
                                {{ $order->created_at->diffInDays($order->updated_at) }} ngày
                            @else
                                {{ $order->created_at->diffInDays(now()) }} ngày
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateOrderStatus() {
    console.log('updateOrderStatus called');
    
    const currentStatus = '{{ $order->status }}';
    const newStatus = document.getElementById('status').value;
    const notes = document.getElementById('notes').value;

    console.log('Current status:', currentStatus);
    console.log('New status:', newStatus);
    console.log('Notes:', notes);

    if (currentStatus === newStatus && !notes) {
        showAlert('warning', 'Không có thay đổi nào để cập nhật.');
        return;
    }

    if (!confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?')) {
        return;
    }

    console.log('About to send AJAX request');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const url = 'http://localhost/webbansach/laravel-app/public/admin/orders/{{ $order->id }}/update-status';
    console.log('URL:', url);
    
    const data = {
        status: newStatus,
        note: notes
    };
    console.log('Data to send:', data);

    $.post(url, data)
    .done(function(response) {
        console.log('Success response:', response);
        if (response.success) {
            showAlert('success', response.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', response.message);
        }
    })
    .fail(function(xhr, status, error) {
        console.log('Error response:', xhr.responseText);
        console.log('Status:', status);
        console.log('Error:', error);
        
        let errorMessage = 'Có lỗi xảy ra khi cập nhật trạng thái.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        } else if (xhr.responseText) {
            try {
                const errorData = JSON.parse(xhr.responseText);
                if (errorData.message) {
                    errorMessage = errorData.message;
                }
            } catch (e) {
                console.log('Cannot parse error response');
            }
        }
        showAlert('error', errorMessage);
    });
}

function printOrder() {
    window.open('http://localhost/webbansach/laravel-app/public/admin/orders/{{ $order->id }}/print', '_blank');
}

function sendNotification() {
    if (!confirm('Bạn có muốn gửi email thông báo cho khách hàng?')) {
        return;
    }

    // Implement notification sending logic
    showAlert('info', 'Chức năng gửi thông báo đang được phát triển.');
}

function cancelOrder() {
    if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này? Hành động này không thể hoàn tác!')) {
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post('http://localhost/webbansach/laravel-app/public/admin/orders/{{ $order->id }}/update-status', {
        status: 'cancelled',
        note: 'Đơn hàng bị hủy bởi quản trị viên'
    })
    .done(function(response) {
        if (response.success) {
            showAlert('success', response.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', response.message);
        }
    })
    .fail(function() {
        showAlert('error', 'Có lỗi xảy ra khi hủy đơn hàng.');
    });
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 
                      type === 'info' ? 'alert-info' : 'alert-danger';
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
</script>
@endpush

@push('styles')
<style>
.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.info-item:last-child {
    border-bottom: none;
}

.info-group h6 {
    font-weight: 600;
    color: #5a5c69;
    margin-bottom: 1rem;
}

.avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
}

.bg-label-primary {
    background-color: #4e73df !important;
}

.customer-stats .stat-item,
.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #eee;
}

.customer-stats .stat-item:last-child,
.stat-item:last-child {
    border-bottom: none;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e3e6f0;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -25px;
    top: 5px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #e3e6f0;
}

.timeline-content {
    background: #f8f9fc;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #4e73df;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
    background-color: #f8f9fc;
}

.badge.fs-6 {
    font-size: 0.9rem !important;
    padding: 0.5rem 0.75rem;
}
</style>
@endpush