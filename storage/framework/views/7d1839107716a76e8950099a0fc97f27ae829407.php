

<?php $__env->startSection('title', 'Chỉnh sửa danh mục'); ?>
<?php $__env->startSection('page-title', 'Chỉnh sửa danh mục: ' . $category->name); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin danh mục</h5>
                <div>
                    <a href="<?php echo e(route('admin.categories.show', $category)); ?>" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Xem chi tiết
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.categories.update', $category)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="name" name="name" value="<?php echo e(old('name', $category->name)); ?>" required
                               placeholder="Nhập tên danh mục...">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">Tên danh mục phải là duy nhất trong hệ thống.</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="description" name="description" rows="4"
                                  placeholder="Nhập mô tả về danh mục (tùy chọn)..."><?php echo e(old('description', $category->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">Mô tả giúp khách hàng hiểu rõ hơn về danh mục sách này.</div>
                    </div>

                    <!-- Category Statistics -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Thông tin danh mục</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small><strong>Số sách:</strong> <?php echo e($category->books->count()); ?> cuốn</small>
                            </div>
                            <div class="col-md-6">
                                <small><strong>Ngày tạo:</strong> <?php echo e($category->created_at->format('d/m/Y H:i')); ?></small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <div>
                            <a href="<?php echo e(route('admin.categories.show', $category)); ?>" class="btn btn-info me-2">
                                <i class="fas fa-eye"></i> Xem chi tiết
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/categories/edit.blade.php ENDPATH**/ ?>