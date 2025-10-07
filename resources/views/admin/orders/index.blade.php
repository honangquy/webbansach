@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý đơn hàng</h1>
            <small class="text-muted">Quản lý và theo dõi tất cả đơn hàng</small>
        </div>
        <div>
            <button class="btn btn-outline-primary" onclick="exportOrders()">
                <i class="fas fa-download"></i> Xuất Excel
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-cog"></i> Thao tác hàng loạt
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="bulkUpdateStatus('processing')">Đặt thành "Đang xử lý"</a></li>
                    <li><a class="dropdown-item" href="#" onclick="bulkUpdateStatus('shipped')">Đặt thành "Đang giao"</a></li>
                    <li><a class="dropdown-item" href="#" onclick="bulkUpdateStatus('delivered')">Đặt thành "Đã giao"</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="bulkUpdateStatus('cancelled')">Hủy đơn hàng</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng đơn hàng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Chờ xử lý
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Doanh thu tháng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['monthly_revenue']) }}đ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Giá trị trung bình
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['average_order_value']) }}đ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bộ lọc và tìm kiếm</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="search" class="form-label">Tìm kiếm</label>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Mã đơn, email, tên khách hàng...">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Tất cả</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Đang giao</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="date_from" class="form-label">Từ ngày</label>
                        <input type="date" 
                               class="form-control" 
                               id="date_from" 
                               name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="date_to" class="form-label">Đến ngày</label>
                        <input type="date" 
                               class="form-control" 
                               id="date_to" 
                               name="date_to" 
                               value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="per_page" class="form-label">Hiển thị</label>
                        <select class="form-select" id="per_page" name="per_page">
                            <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    <div class="col-md-1 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
            <div>
                <input type="checkbox" id="selectAll" class="form-check-input me-2">
                <label for="selectAll" class="form-check-label">Chọn tất cả</label>
            </div>
        </div>
        <div class="card-body">
            @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAllTable" class="form-check-input">
                            </th>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <input type="checkbox" class="order-checkbox form-check-input" value="{{ $order->id }}">
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none fw-bold">
                                    #{{ $order->order_number }}
                                </a>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $order->user->name }}</strong><br>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ $order->created_at->format('d/m/Y') }}<br>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $order->orderDetails->count() }} sản phẩm</span>
                            </td>
                            <td>
                                                            <div class="text-end">
                                <strong class="text-success">{{ number_format($order->final_amount ?? $order->total_amount) }}đ</strong>
                            </td>
                            <td>
                                <select class="form-select form-select-sm status-select" 
                                        data-order-id="{{ $order->id }}" 
                                        data-current-status="{{ $order->status }}">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Đang giao</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-info" 
                                            onclick="printOrder({{ $order->id }})"
                                            title="In đơn hàng">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    Hiển thị {{ $orders->firstItem() }} - {{ $orders->lastItem() }} 
                    trong tổng số {{ $orders->total() }} đơn hàng
                </div>
                <div>
                    {{ $orders->links() }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Không tìm thấy đơn hàng nào</h5>
                <p class="text-muted">Không có đơn hàng nào phù hợp với bộ lọc hiện tại.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Select all functionality
    $('#selectAll, #selectAllTable').change(function() {
        const isChecked = $(this).is(':checked');
        $('.order-checkbox').prop('checked', isChecked);
        $('#selectAll, #selectAllTable').prop('checked', isChecked);
    });

    $('.order-checkbox').change(function() {
        const totalCheckboxes = $('.order-checkbox').length;
        const checkedCheckboxes = $('.order-checkbox:checked').length;
        
        $('#selectAll, #selectAllTable').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    // Status change functionality
    $('.status-select').change(function() {
        const orderId = $(this).data('order-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus !== currentStatus) {
            updateOrderStatus(orderId, newStatus, $(this));
        }
    });

    // Auto-submit form on filter change
    $('#status, #per_page').change(function() {
        $('#filterForm').submit();
    });
});

function updateOrderStatus(orderId, newStatus, selectElement) {
    if (!confirm('Bạn có chắc chắn muốn thay đổi trạng thái đơn hàng này?')) {
        selectElement.val(selectElement.data('current-status'));
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post(`http://localhost/webbansach/laravel-app/public/admin/orders/${orderId}/update-status`, {
        status: newStatus,
        note: 'Cập nhật từ trang danh sách'
    })
    .done(function(response) {
        console.log('Response:', response);
        if (response.success) {
            selectElement.data('current-status', newStatus);
            showAlert('success', response.message);
        } else {
            selectElement.val(selectElement.data('current-status'));
            showAlert('error', response.message);
        }
    })
    .fail(function(xhr, status, error) {
        selectElement.val(selectElement.data('current-status'));
        console.log('AJAX Error:', xhr.responseText);
        console.log('Status:', status);
        console.log('Error:', error);
        showAlert('error', 'Có lỗi xảy ra khi cập nhật trạng thái.');
    });
}

function bulkUpdateStatus(status) {
    const selectedOrders = $('.order-checkbox:checked').map(function() {
        return $(this).val();
    }).get();

    if (selectedOrders.length === 0) {
        showAlert('warning', 'Vui lòng chọn ít nhất một đơn hàng.');
        return;
    }

    const statusText = {
        'processing': 'Đang xử lý',
        'shipped': 'Đang giao',
        'delivered': 'Đã giao',
        'cancelled': 'Đã hủy'
    };

    if (!confirm(`Bạn có chắc chắn muốn đặt ${selectedOrders.length} đơn hàng thành "${statusText[status]}"?`)) {
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post('http://localhost/webbansach/laravel-app/public/admin/orders/bulk-update', {
        order_ids: selectedOrders,
        status: status
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
        showAlert('error', 'Có lỗi xảy ra khi cập nhật trạng thái.');
    });
}

function exportOrders() {
    const params = new URLSearchParams(window.location.search);
    window.open('{{ route('admin.orders.export') }}' + '?' + params.toString());
}

function printOrder(orderId) {
    window.open(`http://localhost/webbansach/laravel-app/public/admin/orders/${orderId}/print`, '_blank');
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 'alert-danger';
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
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
    background-color: #f8f9fc;
}

.table tbody tr:hover {
    background-color: #f8f9fc;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.btn-group .btn {
    margin-right: 0;
}

.status-select {
    min-width: 120px;
}

.form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush