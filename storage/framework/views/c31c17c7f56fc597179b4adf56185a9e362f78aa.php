

<?php $__env->startSection('title', 'Quản lý Flash Sale'); ?>

<?php $__env->startSection('page-title', 'Quản lý Flash Sale'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Danh sách Flash Sale</h3>
    <a href="<?php echo e(route('admin.flash-sales.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tạo Flash Sale mới
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Tiêu đề</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th style="width: 100px;">Số sản phẩm</th>
                        <th style="width: 100px;">Trạng thái</th>
                        <th style="width: 120px;">Tình trạng</th>
                        <th style="width: 200px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $flashSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flashSale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($flashSale->id); ?></td>
                        <td>
                            <strong><?php echo e($flashSale->title); ?></strong>
                            <?php if($flashSale->description): ?>
                                <br><small class="text-muted"><?php echo e(Str::limit($flashSale->description, 50)); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <small><?php echo e($flashSale->start_time->format('d/m/Y')); ?></small><br>
                            <small class="text-muted"><?php echo e($flashSale->start_time->format('H:i')); ?></small>
                        </td>
                        <td>
                            <small><?php echo e($flashSale->end_time->format('d/m/Y')); ?></small><br>
                            <small class="text-muted"><?php echo e($flashSale->end_time->format('H:i')); ?></small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info"><?php echo e($flashSale->items_count); ?></span>
                        </td>
                        <td>
                            <form action="<?php echo e(route('admin.flash-sales.toggle-status', $flashSale->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm <?php echo e($flashSale->status ? 'btn-success' : 'btn-secondary'); ?> w-100">
                                    <?php echo e($flashSale->status ? 'Bật' : 'Tắt'); ?>

                                </button>
                            </form>
                        </td>
                        <td>
                            <?php if($flashSale->hasEnded()): ?>
                                <span class="badge bg-secondary">Đã kết thúc</span>
                            <?php elseif($flashSale->isActive()): ?>
                                <span class="badge bg-success">Đang diễn ra</span>
                            <?php elseif(!$flashSale->hasStarted()): ?>
                                <span class="badge bg-warning">Sắp diễn ra</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Không hoạt động</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('admin.flash-sales.edit', $flashSale->id)); ?>" 
                                   class="btn btn-sm btn-warning" 
                                   title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo e(route('admin.flash-sales.show', $flashSale->id)); ?>" 
                                   class="btn btn-sm btn-info" 
                                   title="Chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="<?php echo e(route('admin.flash-sales.destroy', $flashSale->id)); ?>" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa Flash Sale này không?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có Flash Sale nào. Hãy tạo Flash Sale đầu tiên!</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php echo e($flashSales->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/flash-sales/index.blade.php ENDPATH**/ ?>