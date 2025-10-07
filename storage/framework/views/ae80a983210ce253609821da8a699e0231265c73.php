

<?php $__env->startSection('title', 'Quản lý banner'); ?>

<?php $__env->startSection('page-title', 'Quản lý banner'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Danh sách banner</h3>
    <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-primary">Thêm banner</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Ảnh</th>
            <th>Tiêu đề</th>
            <th>Start</th>
            <th>End</th>
            <th>Active</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($banner->id); ?></td>
            <td style="width:180px">
                <?php if($banner->image_path): ?>
                    <img src="<?php echo e(asset('storage/' . $banner->image_path)); ?>" alt="" class="img-fluid" style="max-height:60px">
                <?php elseif($banner->image_url): ?>
                    <img src="<?php echo e($banner->image_url); ?>" alt="" class="img-fluid" style="max-height:60px">
                <?php endif; ?>
            </td>
            <td><?php echo e($banner->title); ?></td>
            <td><?php echo e(optional($banner->start_at)->format('Y-m-d H:i')); ?></td>
            <td><?php echo e(optional($banner->end_at)->format('Y-m-d H:i')); ?></td>
            <td><?php echo e($banner->active ? 'Có' : 'Không'); ?></td>
            <td>
                <a href="<?php echo e(route('admin.banners.edit', $banner)); ?>" class="btn btn-sm btn-secondary">Sửa</a>
                <form action="<?php echo e(route('admin.banners.destroy', $banner)); ?>" method="POST" style="display:inline-block" onsubmit="return confirm('Xác nhận xóa?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php echo e($banners->links()); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>