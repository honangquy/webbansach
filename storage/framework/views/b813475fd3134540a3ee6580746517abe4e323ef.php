

<?php $__env->startSection('title', 'Quản lý Mã giảm giá'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách Mã giảm giá</h5>
                    <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm mã giảm giá
                    </a>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($coupons->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Mã</th>
                                        <th>Loại</th>
                                        <th>Giá trị</th>
                                        <th>Đơn tối thiểu</th>
                                        <th>Giới hạn sử dụng</th>
                                        <th>Đã sử dụng</th>
                                        <th>Thời gian hiệu lực</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <code><?php echo e($coupon->code); ?></code>
                                            </td>
                                            <td>
                                                <?php if($coupon->type === 'percentage'): ?>
                                                    <span class="badge bg-info">Phần trăm</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Cố định</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($coupon->type === 'percentage'): ?>
                                                    <?php echo e($coupon->value); ?>%
                                                <?php else: ?>
                                                    <?php echo e(number_format($coupon->value)); ?>đ
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($coupon->minimum_order_amount): ?>
                                                    <?php echo e(number_format($coupon->minimum_order_amount)); ?>đ
                                                <?php else: ?>
                                                    Không
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($coupon->usage_limit): ?>
                                                    <?php echo e($coupon->usage_limit); ?>

                                                <?php else: ?>
                                                    Không giới hạn
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($coupon->used_count); ?></td>
                                            <td>
                                                <small>
                                                    Từ: <?php echo e($coupon->starts_at->format('d/m/Y')); ?><br>
                                                    Đến: <?php echo e($coupon->expires_at->format('d/m/Y')); ?>

                                                </small>
                                            </td>
                                            <td>
                                                <?php if($coupon->is_active): ?>
                                                    <?php if($coupon->isExpired()): ?>
                                                        <span class="badge bg-warning">Hết hạn</span>
                                                    <?php elseif($coupon->isUsageLimitReached()): ?>
                                                        <span class="badge bg-danger">Hết lượt</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Hoạt động</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Tạm dừng</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?php echo e(route('admin.coupons.show', $coupon)); ?>" class="btn btn-outline-info" title="Xem">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('admin.coupons.edit', $coupon)); ?>" class="btn btn-outline-primary" title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="<?php echo e(route('admin.coupons.destroy', $coupon)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-outline-danger" title="Xóa" 
                                                                onclick="return confirm('Bạn có chắc muốn xóa mã giảm giá này?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            <?php echo e($coupons->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có mã giảm giá nào</h5>
                            <p class="text-muted">Hãy tạo mã giảm giá đầu tiên để thu hút khách hàng!</p>
                            <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tạo mã giảm giá
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/coupons/index.blade.php ENDPATH**/ ?>