

<?php $__env->startSection('title', 'Sửa banner'); ?>
<?php $__env->startSection('page-title', 'Sửa banner'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.banners.update', $banner)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <?php echo $__env->make('admin.banners._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <button class="btn btn-primary">Lưu</button>
                <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/banners/edit.blade.php ENDPATH**/ ?>