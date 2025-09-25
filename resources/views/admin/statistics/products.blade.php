@extends('layouts.admin')

@section('title', 'Thống kê sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="fas fa-box me-2"></i>Thống kê sản phẩm
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.statistics.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        <select class="form-select" id="sortSelect" style="width: auto;">
            <option value="sold" {{ $sort == 'sold' ? 'selected' : '' }}>Sắp xếp theo lượt bán</option>
            <option value="revenue" {{ $sort == 'revenue' ? 'selected' : '' }}>Sắp xếp theo doanh thu</option>
            <option value="stock" {{ $sort == 'stock' ? 'selected' : '' }}>Sắp xếp theo tồn kho</option>
        </select>
    </div>
</div>

<!-- Stock Alert Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Hết hàng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stockAlerts['out_of_stock']) }}</div>
                        <small class="text-muted">Sản phẩm cần nhập hàng</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Sắp hết hàng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stockAlerts['low_stock']) }}</div>
                        <small class="text-muted">Tồn kho ≤ 5 cuốn</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Giá trị tồn kho
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stockAlerts['total_stock_value']) }}đ</div>
                        <small class="text-muted">Tổng giá trị hàng tồn</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Performance -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Hiệu suất theo danh mục</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Danh mục</th>
                                <th>Số sách</th>
                                <th>Đã bán</th>
                                <th>Doanh thu</th>
                                <th>Hiệu suất</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categoryPerformance as $category)
                            <tr>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if($category->description)
                                        <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $category->books_count }}</span>
                                </td>
                                <td>{{ number_format($category->total_sold) }}</td>
                                <td><strong class="text-success">{{ number_format($category->total_revenue) }}đ</strong></td>
                                <td>
                                    @php
                                        $performance = $category->books_count > 0 ? ($category->total_sold / $category->books_count) : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar 
                                            @if($performance >= 10) bg-success
                                            @elseif($performance >= 5) bg-warning  
                                            @else bg-danger
                                            @endif" 
                                            role="progressbar" 
                                            style="width: {{ min(100, $performance * 2) }}%">
                                            {{ number_format($performance, 1) }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Performance Table -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Chi tiết hiệu suất sản phẩm</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sách</th>
                                <th>Danh mục</th>
                                <th>Giá bán</th>
                                <th>Tồn kho</th>
                                <th>Đã bán</th>
                                <th>Doanh thu</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->image)
                                            <img src="{{ $product->image_url }}" 
                                                 class="me-2 rounded" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ Str::limit($product->title, 30) }}</strong>
                                            <br><small class="text-muted">{{ $product->author }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                </td>
                                <td>{{ number_format($product->price) }}đ</td>
                                <td>
                                    <span class="badge 
                                        @if($product->stock_quantity == 0) bg-danger
                                        @elseif($product->stock_quantity <= 5) bg-warning
                                        @else bg-success
                                        @endif">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td>{{ number_format($product->total_sold) }}</td>
                                <td><strong class="text-success">{{ number_format($product->total_revenue) }}đ</strong></td>
                                <td>
                                    @if($product->stock_quantity == 0)
                                        <span class="badge bg-danger">Hết hàng</span>
                                    @elseif($product->stock_quantity <= 5)
                                        <span class="badge bg-warning">Sắp hết</span>
                                    @elseif($product->total_sold > 50)
                                        <span class="badge bg-success">Bán chạy</span>
                                    @else
                                        <span class="badge bg-info">Bình thường</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->appends(['sort' => $sort])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Sort selector
document.getElementById('sortSelect').addEventListener('change', function() {
    window.location.href = '{{ route("admin.statistics.products") }}?sort=' + this.value;
});
</script>
@endsection

@section('styles')
<style>
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
</style>
@endsection