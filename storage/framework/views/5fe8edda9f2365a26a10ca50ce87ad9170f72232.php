

<?php $__env->startSection('title', 'Chi tiết mã giảm giá'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Chi tiết mã giảm giá: <code><?php echo e($coupon->code); ?></code></h5>
                    <div>
                        <a href="<?php echo e(route('admin.coupons.edit', $coupon)); ?>" class="btn btn-primary me-2">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Thông tin cơ bản</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Mã giảm giá</label>
                                                <div class="fw-bold">
                                                    <code class="fs-5"><?php echo e($coupon->code); ?></code>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Loại giảm giá</label>
                                                <div class="fw-bold">
                                                    <?php if($coupon->type === 'percentage'): ?>
                                                        <span class="badge bg-info fs-6">Phần trăm</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success fs-6">Cố định</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Giá trị giảm</label>
                                                <div class="fw-bold fs-4 text-primary">
                                                    <?php if($coupon->type === 'percentage'): ?>
                                                        <?php echo e($coupon->value); ?>%
                                                    <?php else: ?>
                                                        <?php echo e(number_format($coupon->value)); ?>đ
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Đơn hàng tối thiểu</label>
                                                <div class="fw-bold">
                                                    <?php if($coupon->minimum_order_amount): ?>
                                                        <?php echo e(number_format($coupon->minimum_order_amount)); ?>đ
                                                    <?php else: ?>
                                                        <span class="text-muted">Không yêu cầu</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if($coupon->description): ?>
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Mô tả</label>
                                            <div class="border rounded p-3 bg-light">
                                                <?php echo e($coupon->description); ?>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Usage Limits -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Giới hạn sử dụng</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Giới hạn sử dụng tổng</label>
                                                <div class="fw-bold">
                                                    <?php if($coupon->usage_limit): ?>
                                                        <?php echo e($coupon->usage_limit); ?> lần
                                                    <?php else: ?>
                                                        <span class="text-muted">Không giới hạn</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Giới hạn mỗi người dùng</label>
                                                <div class="fw-bold">
                                                    <?php if($coupon->usage_limit_per_user): ?>
                                                        <?php echo e($coupon->usage_limit_per_user); ?> lần
                                                    <?php else: ?>
                                                        <span class="text-muted">Không giới hạn</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Đã sử dụng</label>
                                                <div class="fw-bold text-info">
                                                    <?php echo e($coupon->used_count); ?> lần
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Còn lại</label>
                                                <div class="fw-bold">
                                                    <?php if($coupon->usage_limit): ?>
                                                        <?php echo e(max(0, $coupon->usage_limit - $coupon->used_count)); ?> lần
                                                    <?php else: ?>
                                                        <span class="text-muted">Không giới hạn</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Time Period -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Thời gian hiệu lực</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Ngày bắt đầu</label>
                                                <div class="fw-bold">
                                                    <?php echo e($coupon->starts_at->format('d/m/Y H:i')); ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Ngày kết thúc</label>
                                                <div class="fw-bold">
                                                    <?php echo e($coupon->expires_at->format('d/m/Y H:i')); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-muted">Thời gian còn lại</label>
                                        <div class="fw-bold">
                                            <?php if($coupon->isExpired()): ?>
                                                <span class="text-danger">Đã hết hạn</span>
                                            <?php else: ?>
                                                <?php
                                                    $diff = now()->diff($coupon->expires_at);
                                                ?>
                                                <?php if($diff->days > 0): ?>
                                                    <?php echo e($diff->days); ?> ngày
                                                <?php endif; ?>
                                                <?php echo e($diff->h); ?> giờ <?php echo e($diff->i); ?> phút
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Status Card -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Trạng thái</h6>
                                </div>
                                <div class="card-body text-center">
                                    <?php if($coupon->is_active): ?>
                                        <?php if($coupon->isExpired()): ?>
                                            <span class="badge bg-warning fs-5 mb-3">Hết hạn</span>
                                        <?php elseif($coupon->isUsageLimitReached()): ?>
                                            <span class="badge bg-danger fs-5 mb-3">Hết lượt sử dụng</span>
                                        <?php else: ?>
                                            <span class="badge bg-success fs-5 mb-3">Đang hoạt động</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="badge bg-secondary fs-5 mb-3">Tạm dừng</span>
                                    <?php endif; ?>

                                    <?php if($coupon->usage_limit): ?>
                                        <div class="progress mb-3">
                                            <?php
                                                $percentage = min(100, ($coupon->used_count / $coupon->usage_limit) * 100);
                                            ?>
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: <?php echo e($percentage); ?>%" 
                                                 aria-valuenow="<?php echo e($percentage); ?>" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                                <?php echo e(round($percentage, 1)); ?>%
                                            </div>
                                        </div>
                                        <small class="text-muted">Tỷ lệ sử dụng</small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Metadata -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Thông tin khác</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Ngày tạo</label>
                                        <div class="fw-bold"><?php echo e($coupon->created_at->format('d/m/Y H:i')); ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Cập nhật lần cuối</label>
                                        <div class="fw-bold"><?php echo e($coupon->updated_at->format('d/m/Y H:i')); ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">ID</label>
                                        <div class="fw-bold">#<?php echo e($coupon->id); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/coupons/show.blade.php ENDPATH**/ ?>