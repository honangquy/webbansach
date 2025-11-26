<div class="mb-3">
    <label class="form-label">Tiêu đề</label>
    <input type="text" name="title" class="form-control" value="<?php echo e(old('title', $banner->title ?? '')); ?>">
    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-3">
    <label class="form-label">Ảnh (tải lên từ máy)</label>
    <input type="file" name="image_file" class="form-control">
    <?php if(!empty($banner->image_path ?? null)): ?>
        <div class="mt-2">
            <img src="<?php echo e(asset('storage/' . $banner->image_path)); ?>" style="max-height:120px" />
        </div>
    <?php endif; ?>
    <?php $__errorArgs = ['image_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-3">
    <label class="form-label">Hoặc URL ảnh (ví dụ https://...)</label>
    <input type="text" name="image_url" class="form-control" value="<?php echo e(old('image_url', $banner->image_url ?? '')); ?>">
    <?php if(!empty($banner->image_url ?? null)): ?>
        <div class="mt-2">
            <img src="<?php echo e($banner->image_url); ?>" style="max-height:120px" />
        </div>
    <?php endif; ?>
    <?php $__errorArgs = ['image_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-3">
    <label class="form-label">Link khi click (tùy chọn)</label>
    <input type="text" name="link" class="form-control" value="<?php echo e(old('link', $banner->link ?? '')); ?>">
    <?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Bắt đầu (start_at)</label>
        <input type="datetime-local" name="start_at" class="form-control" value="<?php echo e(old('start_at', isset($banner->start_at) ? $banner->start_at->format('Y-m-d\TH:i') : '')); ?>">
        <?php $__errorArgs = ['start_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Kết thúc (end_at)</label>
        <input type="datetime-local" name="end_at" class="form-control" value="<?php echo e(old('end_at', isset($banner->end_at) ? $banner->end_at->format('Y-m-d\TH:i') : '')); ?>">
        <?php $__errorArgs = ['end_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="form-check mb-3">
    <input type="hidden" name="active" value="0">
    <input type="checkbox" name="active" value="1" class="form-check-input" id="activeCheck" <?php echo e(old('active', $banner->active ?? true) ? 'checked' : ''); ?>>
    <label for="activeCheck" class="form-check-label">Kích hoạt</label>
</div>
<?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/banners/_form.blade.php ENDPATH**/ ?>