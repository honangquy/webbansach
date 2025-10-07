@extends('layouts.admin')

@section('title', 'Quản lý khách hàng')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý khách hàng</h1>
            <small class="text-muted">Quản lý thông tin khách hàng và tài khoản</small>
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
                                Tổng khách hàng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Khách hàng mới tháng này
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['new_this_month'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
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
                                Tổng đơn hàng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Order::count() }}</div>
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
                                Doanh thu tháng này
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format(\App\Models\Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_amount')) }}đ
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tìm kiếm và lọc</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.customers.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="search" class="form-label">Tìm kiếm</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Tên, email...">
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="date_from" class="form-label">Từ ngày</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="date_to" class="form-label">Đến ngày</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="{{ request('date_to') }}">
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="sort" class="form-label">Sắp xếp</label>
                        <select class="form-control" id="sort" name="sort">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                        </select>
                    </div>
                    
                    <div class="col-md-1 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách khách hàng</h6>
            <small class="text-muted">{{ $customers->total() }} khách hàng</small>
        </div>
        <div class="card-body">
            @if($customers->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thông tin khách hàng</th>
                            <th>Đơn hàng</th>
                            <th>Tổng chi tiêu</th>
                            <th>Ngày đăng ký</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @if($customer->avatar)
                                            <img src="{{ asset('storage/' . $customer->avatar) }}" alt="{{ $customer->name }}" class="rounded-circle admin-customer-avatar">
                                        @else
                                            <div class="avatar-initial bg-label-primary rounded admin-customer-avatar-initial">
                                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $customer->name }}</h6>
                                        <small class="text-muted">{{ $customer->email }}</small>
                                        <div>
                                            @if($customer->role === 'staff')
                                                <span class="badge bg-secondary">Nhân viên</span>
                                            @elseif($customer->role === 'admin')
                                                <span class="badge bg-dark">Admin</span>
                                            @else
                                                <span class="badge bg-light text-dark">Khách hàng</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $customer->orders_count }}</span>
                            </td>
                            <td>
                                <strong class="text-success">
                                    {{ number_format($customer->orders_sum_total_amount ?: 0) }}đ
                                </strong>
                            </td>
                            <td>{{ $customer->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                            data-bs-toggle="dropdown">
                                        Hành động
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.customers.show', $customer) }}">
                                                <i class="fas fa-eye"></i> Xem chi tiết
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.customers.edit', $customer) }}">
                                                <i class="fas fa-edit"></i> Chỉnh sửa
                                            </a>
                                        </li>
                                        @if($customer->orders_count == 0)
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.customers.destroy', $customer) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </li>
                                        @endif

                                        @if($customer->role !== 'admin')
                                            <li><hr class="dropdown-divider"></li>
                                            <li class="px-3">
                                                @if($customer->role === 'staff')
                                                    <form action="{{ route('admin.customers.demote', $customer) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-warning w-100">
                                                            <i class="fas fa-user-minus"></i> Gỡ quyền nhân viên
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.customers.promote', $customer) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                                            <i class="fas fa-user-plus"></i> Nâng quyền thành nhân viên
                                                        </button>
                                                    </form>
                                                @endif
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $customers->links() }}
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Không tìm thấy khách hàng nào</h5>
                <p class="text-muted">Thử thay đổi bộ lọc để xem kết quả khác.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Show alert message
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
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

.avatar-initial {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
}

/* Admin customers avatar image */
.admin-customer-avatar {
    width: 48px;
    height: 48px;
    object-fit: cover;
}
.admin-customer-avatar-initial {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
}

.bg-label-primary {
    background-color: #4e73df !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>
@endpush