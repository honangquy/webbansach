@extends('layouts.admin')

@section('title', 'Thống kê bán hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="fas fa-chart-bar me-2"></i>Thống kê bán hàng
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.statistics.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        <a href="#" id="exportCsvBtn" class="btn btn-outline-success">
            <i class="fas fa-file-csv"></i> Xuất CSV
        </a>
        <select class="form-select" id="periodSelect" style="width: auto;">
            <option value="7" {{ $khoang_ngay == '7' ? 'selected' : '' }}>7 ngày qua</option>
            <option value="30" {{ $khoang_ngay == '30' ? 'selected' : '' }}>30 ngày qua</option>
            <option value="90" {{ $khoang_ngay == '90' ? 'selected' : '' }}>90 ngày qua</option>
            <option value="365" {{ $khoang_ngay == '365' ? 'selected' : '' }}>1 năm qua</option>
        </select>
    </div>
</div>

<!-- Sales by Month Chart -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo tháng (12 tháng gần nhất)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="monthlySalesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Methods and Daily Sales -->
<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Phương thức thanh toán</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie">
                    <canvas id="paymentMethodChart"></canvas>
                </div>
                <div class="mt-3">
                    @foreach($paymentMethods as $method)
                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            @switch($method->payment_method)
                                @case('cod') <i class="fas fa-truck text-warning"></i> COD @break
                                @case('bank_transfer') <i class="fas fa-university text-info"></i> Chuyển khoản @break
                                @case('qr_code') <i class="fas fa-qrcode text-success"></i> QR Code @break
                            @endswitch
                        </span>
                        <div class="text-end">
                            <div>{{ $method->count }} đơn</div>
                            <small class="text-muted">{{ number_format($method->revenue) }}đ</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Doanh thu hàng ngày ({{ $khoang_ngay }} ngày qua)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Số đơn hàng</th>
                                <th>Doanh thu</th>
                                <th>Trung bình/đơn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailySales->reverse() as $sale)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</td>
                                <td>{{ $sale->orders }}</td>
                                <td>{{ number_format($sale->revenue) }}đ</td>
                                <td>{{ $sale->orders > 0 ? number_format($sale->revenue / $sale->orders) : 0 }}đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <th>Tổng cộng</th>
                                <th>{{ $dailySales->sum('orders') }}</th>
                                <th>{{ number_format($dailySales->sum('revenue')) }}đ</th>
                                <th>{{ $dailySales->sum('orders') > 0 ? number_format($dailySales->sum('revenue') / $dailySales->sum('orders')) : 0 }}đ</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Sales Chart
const monthlyCtx = document.getElementById('monthlySalesChart').getContext('2d');
const monthlyChart = new Chart(monthlyCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($salesByMonth->map(function($item) { return $item->month . '/' . $item->year; })) !!},
        datasets: [{
            label: 'Doanh thu (đ)',
            data: {!! json_encode($salesByMonth->pluck('revenue')) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }, {
            label: 'Số đơn hàng',
            data: {!! json_encode($salesByMonth->pluck('orders')) !!},
            type: 'line',
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                position: 'left',
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString() + 'đ';
                    }
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                beginAtZero: true,
                grid: {
                    drawOnChartArea: false,
                }
            }
        }
    }
});

// Payment Method Chart
const paymentCtx = document.getElementById('paymentMethodChart').getContext('2d');
const paymentChart = new Chart(paymentCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($paymentMethods->pluck('payment_method')) !!},
        datasets: [{
            data: {!! json_encode($paymentMethods->pluck('revenue')) !!},
            backgroundColor: [
                '#f6c23e', // COD
                '#36b9cc', // Bank Transfer
                '#1cc88a'  // QR Code
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Period selector
document.getElementById('periodSelect').addEventListener('change', function() {
    window.location.href = '{{ route("admin.statistics.sales") }}?khoang_ngay=' + this.value;
});

// Export CSV
document.getElementById('exportCsvBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const p = document.getElementById('periodSelect').value;
    window.open('{{ route("admin.statistics.export") }}?loai=sales&khoang_ngay=' + p, '_blank');
});
</script>
@endsection

@section('styles')
<style>
.chart-area {
    position: relative;
    height: 400px;
    width: 100%;
}
.chart-pie {
    position: relative;
    height: 300px;
    width: 100%;
}
</style>
@endsection