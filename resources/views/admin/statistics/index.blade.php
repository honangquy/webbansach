@extends('layouts.admin')

@section('title', 'Thống kê tổng quan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="fas fa-chart-line me-2"></i>Thống kê tổng quan
    </h1>
    <div class="d-flex gap-2">
        <select class="form-select" id="periodSelect" style="width: auto;">
            <option value="7" {{ $period == '7' ? 'selected' : '' }}>7 ngày qua</option>
            <option value="30" {{ $period == '30' ? 'selected' : '' }}>30 ngày qua</option>
            <option value="90" {{ $period == '90' ? 'selected' : '' }}>90 ngày qua</option>
            <option value="365" {{ $period == '365' ? 'selected' : '' }}>1 năm qua</option>
        </select>
        <button class="btn btn-primary" onclick="refreshData()">
            <i class="fas fa-sync-alt"></i> Làm mới
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Tổng đơn hàng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_orders']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Doanh thu
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_revenue']) }}đ</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Khách hàng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_customers']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Sản phẩm
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_books']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Navigation -->
<div class="row mb-4">
    <div class="col-md-3">
        <a href="{{ route('admin.statistics.sales') }}" class="card text-decoration-none">
            <div class="card-body text-center">
                <i class="fas fa-chart-bar fa-3x text-primary mb-2"></i>
                <h5>Thống kê bán hàng</h5>
                <p class="text-muted">Chi tiết doanh thu, đơn hàng theo thời gian</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.statistics.customers') }}" class="card text-decoration-none">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x text-success mb-2"></i>
                <h5>Thống kê khách hàng</h5>
                <p class="text-muted">Phân tích khách hàng và xu hướng đăng ký</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.statistics.products') }}" class="card text-decoration-none">
            <div class="card-body text-center">
                <i class="fas fa-box fa-3x text-info mb-2"></i>
                <h5>Thống kê sản phẩm</h5>
                <p class="text-muted">Hiệu suất bán hàng và tồn kho</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-2"></i>
                <h5>Cảnh báo</h5>
                <p class="text-muted mb-2">{{ $stats['pending_orders'] }} đơn chờ xử lý</p>
                <p class="text-muted">{{ $stats['low_stock_books'] }} sách sắp hết</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <div class="col-xl-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Biểu đồ doanh thu</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Tùy chọn:</div>
                        <a class="dropdown-item" href="{{ route('admin.statistics.sales') }}">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area" style="position: relative; height: 400px; width: 100%;">
                    <canvas id="revenueChart" style="display: block; width: 100%; height: 400px;"></canvas>
                    <div id="revenueChartLoading" class="chart-loading" style="display: none;">
                        <span>Đang tải biểu đồ...</span>
                    </div>
                </div>
                <div id="revenueChartFallback" style="display: none;">
                    <i class="fas fa-chart-line fa-3x"></i>
                    <h6 class="mt-3">Chưa có dữ liệu doanh thu</h6>
                    <p class="mb-0">Biểu đồ sẽ hiển thị khi có đơn hàng được hoàn thành</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Trạng thái đơn hàng</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4" style="position: relative; height: 300px; width: 100%;">
                    <canvas id="orderStatusChart" style="display: block; width: 100%; height: 300px;"></canvas>
                    <div id="statusChartLoading" class="chart-loading" style="display: none;">
                        <span>Đang tải biểu đồ...</span>
                    </div>
                </div>
                <div id="statusChartFallback" style="display: none;">
                    <i class="fas fa-chart-pie fa-3x"></i>
                    <h6 class="mt-3">Chưa có dữ liệu trạng thái</h6>
                    <p class="mb-0">Biểu đồ sẽ hiển thị khi có đơn hàng trong hệ thống</p>
                </div>
                <div class="mt-4 text-center small">
                    @foreach($ordersByStatus as $status => $count)
                    <span class="mr-2">
                        <i class="fas fa-circle 
                            @if($status == 'pending') text-warning
                            @elseif($status == 'processing') text-info  
                            @elseif($status == 'shipped') text-primary
                            @elseif($status == 'delivered') text-success
                            @elseif($status == 'cancelled') text-danger
                            @endif"></i>
                        {{ ucfirst($status) }}: {{ $count }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Books and Recent Customers -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sách bán chạy nhất</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Sách</th>
                                <th>Đã bán</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($topBooks->count() > 0)
                                @foreach($topBooks as $book)
                                <tr>
                                    <td>
                                        @if($book->book)
                                            <strong>{{ Str::limit($book->book->title, 30) }}</strong><br>
                                            <small class="text-muted">{{ $book->book->author }}</small>
                                        @else
                                            <em class="text-muted">Sách không tồn tại</em>
                                        @endif
                                    </td>
                                    <td>{{ $book->total_sold }}</td>
                                    <td>
                                        @if($book->book)
                                            {{ number_format($book->book->price * $book->total_sold) }}đ
                                        @else
                                            0đ
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        <em>Chưa có dữ liệu bán hàng</em>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Khách hàng mới nhất</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Ngày đăng ký</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentCustomers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Try multiple CDN sources for Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js" 
        onerror="this.onerror=null; this.src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js';"
        onload="console.log('Chart.js loaded from CDN')"></script>

<script>
// More robust Chart.js loading with multiple fallbacks
function loadChartJS() {
    return new Promise((resolve, reject) => {
        // Check if Chart is already available
        if (typeof Chart !== 'undefined') {
            console.log('Chart.js already loaded');
            resolve();
            return;
        }

        let attempts = 0;
        const maxAttempts = 50; // 5 seconds total
        
        function checkChart() {
            attempts++;
            if (typeof Chart !== 'undefined') {
                console.log('Chart.js loaded successfully after', attempts, 'attempts');
                resolve();
            } else if (attempts >= maxAttempts) {
                console.error('Chart.js failed to load after', maxAttempts, 'attempts');
                reject(new Error('Chart.js failed to load'));
            } else {
                console.log('Chart.js not loaded yet, attempt', attempts, '/', maxAttempts);
                setTimeout(checkChart, 100);
            }
        }
        
        checkChart();
    });
}

// Initialize charts with better error handling
async function initializeCharts() {
    try {
        // Show loading indicators
        const revenueLoading = document.getElementById('revenueChartLoading');
        const statusLoading = document.getElementById('statusChartLoading');
        if (revenueLoading) revenueLoading.style.display = 'flex';
        if (statusLoading) statusLoading.style.display = 'flex';

        // Wait for Chart.js to load
        await loadChartJS();
        
        // Debug data
        const revenueData = {!! json_encode($revenueData) !!};
        const ordersByStatus = {!! json_encode($ordersByStatus) !!};
        
        console.log('Revenue Data:', revenueData);
        console.log('Orders by Status:', ordersByStatus);

        // Hide loading indicators
        if (revenueLoading) revenueLoading.style.display = 'none';
        if (statusLoading) statusLoading.style.display = 'none';

        // Revenue Chart
        await createRevenueChart(revenueData);
        
        // Order Status Chart  
        await createStatusChart(ordersByStatus);
        
    } catch (error) {
        console.error('Failed to initialize charts:', error);
        showChartError('Chart.js library failed to load. Please check your internet connection.');
    }
}

async function createRevenueChart(revenueData) {
    try {
        const revenueCtx = document.getElementById('revenueChart');
        if (!revenueCtx) {
            console.error('Revenue chart canvas not found');
            return;
        }

        const revenueLabels = revenueData.map(item => item.date);
        const revenueValues = revenueData.map(item => item.revenue);

        console.log('Revenue Labels:', revenueLabels);
        console.log('Revenue Values:', revenueValues);

        // Check if we have meaningful data
        const hasData = revenueLabels.length > 0 && revenueValues.some(v => v > 0);
        
        if (!hasData) {
            console.log('No revenue data, showing fallback');
            revenueCtx.style.display = 'none';
            document.getElementById('revenueChartFallback').style.display = 'block';
            return;
        }

        console.log('Creating revenue chart with Chart.js');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueLabels.map(date => {
                    return new Date(date).toLocaleDateString('vi-VN');
                }),
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: revenueValues,
                    borderColor: 'rgb(78, 115, 223)',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: 'rgb(78, 115, 223)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + 
                                       new Intl.NumberFormat('vi-VN').format(context.raw) + 'đ';
                            }
                        }
                    }
                }
            }
        });
        console.log('Revenue chart created successfully');
    } catch (error) {
        console.error('Revenue Chart Error:', error);
        showChartError('Revenue chart: ' + error.message, 'revenueChart', 'revenueChartFallback');
    }
}

async function createStatusChart(ordersByStatus) {
    try {
        const statusCtx = document.getElementById('orderStatusChart');
        if (!statusCtx) {
            console.error('Status chart canvas not found');
            return;
        }

        const statusLabels = Object.keys(ordersByStatus);
        const statusValues = Object.values(ordersByStatus);

        console.log('Status Labels:', statusLabels);
        console.log('Status Values:', statusValues);

        // Status translations
        const statusTranslations = {
            'pending': 'Chờ xử lý',
            'processing': 'Đang xử lý', 
            'shipped': 'Đã giao',
            'delivered': 'Hoàn thành',
            'cancelled': 'Đã hủy'
        };

        // Check if we have meaningful data
        const hasData = statusLabels.length > 0 && statusValues.some(v => v > 0);

        if (!hasData) {
            console.log('No status data, showing fallback');
            statusCtx.style.display = 'none';
            document.getElementById('statusChartFallback').style.display = 'block';
            return;
        }

        console.log('Creating status chart with Chart.js');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels.map(status => statusTranslations[status] || status),
                datasets: [{
                    data: statusValues,
                    backgroundColor: [
                        '#f6c23e', // pending - warning
                        '#36b9cc', // processing - info  
                        '#4e73df', // shipped - primary
                        '#1cc88a', // delivered - success
                        '#e74a3b'  // cancelled - danger
                    ],
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return context.label + ': ' + context.raw + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
        console.log('Status chart created successfully');
    } catch (error) {
        console.error('Status Chart Error:', error);
        showChartError('Status chart: ' + error.message, 'orderStatusChart', 'statusChartFallback');
    }
}

function showChartError(message, canvasId, fallbackId) {
    const canvas = document.getElementById(canvasId);
    const fallback = document.getElementById(fallbackId);
    
    if (canvas) canvas.style.display = 'none';
    if (fallback) {
        fallback.style.display = 'block';
        fallback.innerHTML = `
            <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
            <h6 class="mt-3 text-danger">Lỗi hiển thị biểu đồ</h6>
            <p class="text-muted mb-0">${message}</p>
            <button class="btn btn-sm btn-outline-primary mt-2" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i> Thử lại
            </button>
        `;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initializeCharts);

// Also try when window loads (fallback)
window.addEventListener('load', function() {
    if (typeof Chart === 'undefined') {
        console.log('Retrying chart initialization on window load...');
        setTimeout(initializeCharts, 1000);
    }
});

// Period selector
document.addEventListener('DOMContentLoaded', function() {
    const periodSelect = document.getElementById('periodSelect');
    if (periodSelect) {
        periodSelect.addEventListener('change', function() {
            window.location.href = '{{ route("admin.statistics.index") }}?period=' + this.value;
        });
    }
});

function refreshData() {
    window.location.reload();
}
</script>
@endsection

@section('styles')
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

.chart-area {
    position: relative;
    height: 400px;
    width: 100%;
    background: #fff;
    border-radius: 8px;
    padding: 10px;
}

.chart-pie {
    position: relative;
    height: 300px;
    width: 100%;
    background: #fff;
    border-radius: 8px;
    padding: 10px;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    border: 1px solid #e3e6f0;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.font-weight-bold {
    font-weight: 700 !important;
}

.text-xs {
    font-size: 0.7rem;
}

/* Loading animation */
.chart-loading {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    color: #6c757d;
}

.chart-loading::after {
    content: "";
    width: 20px;
    height: 20px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-left: 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive improvements */
@media (max-width: 768px) {
    .chart-area, .chart-pie {
        height: 250px;
    }
}

/* Better fallback styling */
#revenueChartFallback, #statusChartFallback {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    color: #6c757d;
    padding: 40px 20px;
    text-align: center;
}

#revenueChartFallback i, #statusChartFallback i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
</style>
@endsection