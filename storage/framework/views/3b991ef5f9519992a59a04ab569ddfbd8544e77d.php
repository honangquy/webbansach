

<?php $__env->startSection('title', 'Chi tiết Flash Sale'); ?>

<?php $__env->startSection('page-title', 'Chi tiết Flash Sale'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-3">
    <a href="<?php echo e(route('admin.flash-sales.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
    </a>
    <a href="<?php echo e(route('admin.flash-sales.edit', $flashSale->id)); ?>" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Chỉnh sửa
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Thông tin Flash Sale</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">Tiêu đề</th>
                        <td><?php echo e($flashSale->title); ?></td>
                    </tr>
                    <tr>
                        <th>Mô tả</th>
                        <td><?php echo e($flashSale->description ?? 'Không có'); ?></td>
                    </tr>
                    <tr>
                        <th>Thời gian bắt đầu</th>
                        <td><?php echo e($flashSale->start_time->format('d/m/Y H:i')); ?></td>
                    </tr>
                    <tr>
                        <th>Thời gian kết thúc</th>
                        <td><?php echo e($flashSale->end_time->format('d/m/Y H:i')); ?></td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            <span class="badge <?php echo e($flashSale->status ? 'bg-success' : 'bg-secondary'); ?>">
                                <?php echo e($flashSale->status ? 'Bật' : 'Tắt'); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tình trạng</th>
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
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Thống kê</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-muted">Số sản phẩm</h6>
                    <h3><?php echo e($flashSale->items->count()); ?></h3>
                </div>
                <div class="mb-3">
                    <h6 class="text-muted">Tổng số lượng</h6>
                    <h3><?php echo e($flashSale->items->sum('stock_quantity')); ?></h3>
                </div>
                <div class="mb-3">
                    <h6 class="text-muted">Đã bán</h6>
                    <h3><?php echo e($flashSale->items->sum('sold_quantity')); ?></h3>
                </div>
                <div>
                    <h6 class="text-muted">Còn lại</h6>
                    <h3><?php echo e($flashSale->items->sum('stock_quantity') - $flashSale->items->sum('sold_quantity')); ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Danh sách sản phẩm</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hình ảnh</th>
                        <th>Tên sách</th>
                        <th>Giá gốc</th>
                        <th>Giá Flash Sale</th>
                        <th>Giảm giá</th>
                        <th>Số lượng</th>
                        <th>Đã bán</th>
                        <th>Còn lại</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $flashSale->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td>
                            <?php if($item->book->image): ?>
                                <img src="<?php echo e($item->book->image_url); ?>" 
                                     alt="<?php echo e($item->book->title); ?>" 
                                     style="width: 50px; height: 70px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 70px;">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo e($item->book->title); ?></strong><br>
                            <small class="text-muted"><?php echo e($item->book->author); ?></small>
                        </td>
                        <td><?php echo e(number_format($item->book->price)); ?>đ</td>
                        <td><strong class="text-danger"><?php echo e(number_format($item->flash_price)); ?>đ</strong></td>
                        <td>
                            <span class="badge bg-danger">-<?php echo e($item->discount_percent); ?>%</span>
                        </td>
                        <td><?php echo e($item->stock_quantity); ?></td>
                        <td><?php echo e($item->sold_quantity); ?></td>
                        <td>
                            <span class="badge <?php echo e($item->remaining_stock > 0 ? 'bg-success' : 'bg-secondary'); ?>">
                                <?php echo e($item->remaining_stock); ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/flash-sales/show.blade.php ENDPATH**/ ?>