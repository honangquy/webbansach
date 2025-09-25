

<?php $__env->startSection('title', 'Quản lý danh mục'); ?>
<?php $__env->startSection('page-title', 'Quản lý danh mục sách'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Danh sách danh mục</h4>
        <p class="text-muted mb-0">Quản lý các danh mục sách trong hệ thống</p>
    </div>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm danh mục mới
    </a>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.categories.index')); ?>" class="row align-items-end">
            <div class="col-md-6">
                <label for="search" class="form-label">Tìm kiếm</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="<?php echo e(request('search')); ?>" placeholder="Tìm theo tên hoặc mô tả...">
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-refresh"></i> Làm mới
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-body">
        <?php if($categories->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Mô tả</th>
                            <th>Số sách</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><strong>#<?php echo e($category->id); ?></strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-0"><?php echo e($category->name); ?></h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if($category->description): ?>
                                    <span class="text-muted"><?php echo e(Str::limit($category->description, 60)); ?></span>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Chưa có mô tả</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-info"><?php echo e($category->books_count); ?> sách</span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?php echo e($category->created_at->format('d/m/Y')); ?><br>
                                    <?php echo e($category->created_at->format('H:i')); ?>

                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.categories.show', $category)); ?>" 
                                       class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                                       class="btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if($category->books_count == 0): ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                title="Xóa" data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal<?php echo e($category->id); ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                title="Không thể xóa vì có sách" disabled>
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal<?php echo e($category->id); ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Xác nhận xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <small class="text-muted">
                        Hiển thị <?php echo e($categories->firstItem()); ?> đến <?php echo e($categories->lastItem()); ?> 
                        trong tổng số <?php echo e($categories->total()); ?> danh mục
                    </small>
                </div>
                <div>
                    <?php echo e($categories->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5>Chưa có danh mục nào</h5>
                <p class="text-muted">Bấm nút "Thêm danh mục mới" để tạo danh mục đầu tiên.</p>
                <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm danh mục mới
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>