

<?php $__env->startSection('title', 'Chi tiết danh mục'); ?>
<?php $__env->startSection('page-title', 'Chi tiết danh mục: ' . $category->name); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Category Info -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin danh mục</h5>
                <div>
                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <?php if($category->books->count() == 0): ?>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>#<?php echo e($category->id); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tên:</strong></td>
                            <td><?php echo e($category->name); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Mô tả:</strong></td>
                            <td><?php echo e($category->description ?: 'Chưa có mô tả'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Số sách:</strong></td>
                            <td>
                                <span class="badge bg-primary"><?php echo e($category->books->count()); ?> cuốn</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Ngày tạo:</strong></td>
                            <td><?php echo e($category->created_at->format('d/m/Y H:i:s')); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Cập nhật:</strong></td>
                            <td><?php echo e($category->updated_at->format('d/m/Y H:i:s')); ?></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Statistics -->
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="card-title text-primary"><?php echo e($category->books->count()); ?></h5>
                                <p class="card-text">Tổng sách</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="card-title text-success"><?php echo e($category->books->where('status', 1)->count()); ?></h5>
                                <p class="card-text">Đang bán</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Books in Category -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sách trong danh mục (<?php echo e($category->books->count()); ?>)</h5>
            </div>
            <div class="card-body">
                <?php if($category->books->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên sách</th>
                                    <th>Tác giả</th>
                                    <th>Giá</th>
                                    <th>Kho</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $category->books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                            <?php if($book->image): ?>
                                                <img src="<?php echo e($book->image_url); ?>" alt="<?php echo e($book->title); ?>" 
                                                 class="img-thumbnail" style="width: 40px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 50px;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0"><?php echo e(Str::limit($book->title, 30)); ?></h6>
                                            <?php if($book->featured): ?>
                                                <span class="badge bg-warning text-dark">Nổi bật</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?php echo e($book->author); ?></td>
                                    <td>
                                        <div>
                                            <strong class="text-danger"><?php echo e(number_format($book->price)); ?>đ</strong>
                                            <?php if($book->sale_price && $book->sale_price < $book->price): ?>
                                                <br><small class="text-muted text-decoration-line-through"><?php echo e(number_format($book->sale_price)); ?>đ</small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo e($book->stock_quantity > 10 ? 'bg-success' : ($book->stock_quantity > 0 ? 'bg-warning' : 'bg-danger')); ?>">
                                            <?php echo e($book->stock_quantity); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if($book->status): ?>
                                            <span class="badge bg-success">Đang bán</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Ngừng bán</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.books.show', $book)); ?>" 
                                               class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.books.edit', $book)); ?>" 
                                               class="btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5>Chưa có sách nào trong danh mục này</h5>
                        <p class="text-muted">Hãy thêm sách vào danh mục này để bắt đầu bán hàng.</p>
                        <a href="<?php echo e(route('admin.books.create')); ?>?category_id=<?php echo e($category->id); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm sách mới
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách
            </a>
            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Chỉnh sửa danh mục
            </a>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<?php if($category->books->count() == 0): ?>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa danh mục <strong>"<?php echo e($category->name); ?>"</strong> không?</p>
                <p class="text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Hành động này không thể hoàn tác!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Xóa danh mục</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/categories/show.blade.php ENDPATH**/ ?>