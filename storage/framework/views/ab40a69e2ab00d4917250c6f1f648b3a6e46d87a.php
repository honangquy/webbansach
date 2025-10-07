

<?php $__env->startSection('title', 'Chi tiết khách hàng - ' . $customer->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Chi tiết khách hàng</h1>
            <small class="text-muted">Thông tin chi tiết và lịch sử hoạt động</small>
        </div>
        <div>
            <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="<?php echo e(route('admin.customers.edit', $customer)); ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Chỉnh sửa
            </a>
            <?php if($customer->role !== 'admin'): ?>
                <?php if($customer->role === 'staff'): ?>
                    <form action="<?php echo e(route('admin.customers.demote', $customer)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-user-minus"></i> Gỡ quyền nhân viên
                        </button>
                    </form>
                <?php else: ?>
                    <form action="<?php echo e(route('admin.customers.promote', $customer)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus"></i> Nâng quyền thành nhân viên
                        </button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <!-- Customer Information -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin cá nhân</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-initial bg-label-primary rounded-circle" style="width: 80px; height: 80px; font-size: 2rem;">
                                <?php echo e(strtoupper(substr($customer->name, 0, 1))); ?>

                            </div>
                        </div>
                        <h5 class="mb-1"><?php echo e($customer->name); ?></h5>
                        <p class="text-muted mb-2"><?php echo e($customer->email); ?></p>
                        <div class="mb-2">
                            <?php if($customer->role === 'staff'): ?>
                                <span class="badge bg-secondary">Nhân viên</span>
                            <?php elseif($customer->role === 'admin'): ?>
                                <span class="badge bg-dark">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-light text-dark">Khách hàng</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="mb-1 text-primary"><?php echo e($customer->orders_count); ?></h4>
                                <p class="text-muted mb-0">Đơn hàng</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-1 text-success"><?php echo e(number_format($customer->orders_sum_total_amount ?: 0)); ?>đ</h4>
                            <p class="text-muted mb-0">Tổng chi tiêu</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="info-list">
                        <div class="info-item mb-3">
                            <strong class="text-dark">ID khách hàng:</strong>
                            <span class="float-end">#<?php echo e($customer->id); ?></span>
                        </div>
                        <div class="info-item mb-3">
                            <strong class="text-dark">Ngày đăng ký:</strong>
                            <span class="float-end"><?php echo e($customer->created_at->format('d/m/Y H:i')); ?></span>
                        </div>
                        <div class="info-item mb-3">
                            <strong class="text-dark">Lần cuối hoạt động:</strong>
                            <span class="float-end"><?php echo e($customer->updated_at->format('d/m/Y H:i')); ?></span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <?php if($customer->orders_count == 0): ?>
                        <button class="btn btn-outline-danger" onclick="deleteCustomer()">
                            <i class="fas fa-trash"></i> Xóa khách hàng
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders and Statistics -->
        <div class="col-xl-8 col-lg-7">
            <!-- Order Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Tổng đơn hàng
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($orderStats['total']); ?></div>
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
                                        Đang xử lý
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($orderStats['pending']); ?></div>
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
                                        Hoàn thành
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($orderStats['completed']); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Đã hủy
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($orderStats['cancelled']); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Đơn hàng gần đây</h6>
                    <a href="<?php echo e(route('admin.orders.index', ['search' => $customer->email])); ?>" class="btn btn-sm btn-outline-primary">
                        Xem tất cả
                    </a>
                </div>
                <div class="card-body">
                    <?php if($recentOrders->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Sản phẩm</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="text-decoration-none">
                                            #<?php echo e($order->order_number); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($order->created_at->format('d/m/Y')); ?></td>
                                    <td>
                                        <small><?php echo e($order->orderDetails->count()); ?> sản phẩm</small>
                                    </td>
                                    <td>
                                        <strong class="text-success"><?php echo e(number_format($order->total_amount)); ?>đ</strong>
                                    </td>
                                    <td>
                                        <?php switch($order->status):
                                            case ('pending'): ?>
                                                <span class="badge bg-warning">Chờ xử lý</span>
                                                <?php break; ?>
                                            <?php case ('processing'): ?>
                                                <span class="badge bg-info">Đang xử lý</span>
                                                <?php break; ?>
                                            <?php case ('shipped'): ?>
                                                <span class="badge bg-primary">Đang giao</span>
                                                <?php break; ?>
                                            <?php case ('delivered'): ?>
                                                <span class="badge bg-success">Đã giao</span>
                                                <?php break; ?>
                                            <?php case ('cancelled'): ?>
                                                <span class="badge bg-danger">Đã hủy</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có đơn hàng nào</h5>
                        <p class="text-muted">Khách hàng này chưa thực hiện đơn hàng nào.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function deleteCustomer() {
    if (!confirm('Bạn có chắc chắn muốn xóa khách hàng này? Hành động này không thể hoàn tác!')) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo e(route("admin.customers.destroy", $customer)); ?>';
    
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    
    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = '_token';
    tokenInput.value = '<?php echo e(csrf_token()); ?>';
    
    form.appendChild(methodInput);
    form.appendChild(tokenInput);
    document.body.appendChild(form);
    form.submit();
}

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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
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

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/customers/show.blade.php ENDPATH**/ ?>