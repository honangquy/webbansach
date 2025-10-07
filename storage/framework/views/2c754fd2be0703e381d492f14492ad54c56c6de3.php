

<?php $__env->startSection('title', 'Thống kê khách hàng'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="fas fa-users me-2"></i>Thống kê khách hàng
    </h1>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.statistics.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        <a href="#" id="exportCsvBtn" class="btn btn-outline-success">
            <i class="fas fa-file-csv"></i> Xuất CSV
        </a>
    </div>
</div>

<!-- Customer Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Khách hàng hoạt động
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(number_format($customerStats['active_customers'])); ?></div>
                        <small class="text-muted">Có đơn hàng trong 3 tháng qua</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Khách hàng mới tháng này
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(number_format($customerStats['new_customers_this_month'])); ?></div>
                        <small class="text-muted">Đăng ký từ đầu tháng</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
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
                            Đã mua hàng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(number_format($customerStats['customers_with_orders'])); ?></div>
                        <small class="text-muted">Có ít nhất 1 đơn hàng</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customer Registration Trend -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Xu hướng đăng ký khách hàng (12 tháng qua)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="customerRegistrationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Customers -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Top 20 khách hàng thân thiết</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên khách hàng</th>
                                <th>Email</th>
                                <th>Số đơn hàng</th>
                                <th>Tổng chi tiêu</th>
                                <th>Ngày đăng ký</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $topCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <strong><?php echo e($customer->name); ?></strong>
                                    <?php if($customer->phone): ?>
                                        <br><small class="text-muted"><?php echo e($customer->phone); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($customer->email); ?></td>
                                <td>
                                    <span class="badge bg-primary"><?php echo e($customer->orders_count); ?></span>
                                </td>
                                <td>
                                    <strong class="text-success">
                                        <?php echo e(number_format($customer->orders->first()->total_spent ?? 0)); ?>đ
                                    </strong>
                                </td>
                                <td><?php echo e($customer->created_at->format('d/m/Y')); ?></td>
                                <td>
                                    <?php if($customer->orders_count > 0): ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Chưa mua</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Customer Registration Chart
const registrationCtx = document.getElementById('customerRegistrationChart').getContext('2d');
const registrationChart = new Chart(registrationCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($customerRegistrations->map(function($item) { return $item->month . '/' . $item->year; })); ?>,
        datasets: [{
            label: 'Số khách hàng đăng ký',
            data: <?php echo json_encode($customerRegistrations->pluck('count')); ?>,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<script>
// Export CSV for customers
document.getElementById('exportCsvBtn').addEventListener('click', function(e) {
    e.preventDefault();
    window.open('<?php echo e(route("admin.statistics.export")); ?>?loai=customers', '_blank');
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
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
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/statistics/customers.blade.php ENDPATH**/ ?>