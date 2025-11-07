

<?php $__env->startSection('title', 'Chỉnh sửa mã giảm giá'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Chỉnh sửa mã giảm giá: <code><?php echo e($coupon->code); ?></code></h5>
                    <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.coupons.update', $coupon)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="code" name="code" value="<?php echo e(old('code', $coupon->code)); ?>" 
                                           placeholder="VD: SALE20" style="text-transform: uppercase;">
                                    <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Mã sẽ được tự động chuyển thành chữ hoa</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
                                    <select class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="type" name="type">
                                        <option value="">Chọn loại giảm giá</option>
                                        <option value="percentage" <?php echo e(old('type', $coupon->type) == 'percentage' ? 'selected' : ''); ?>>Phần trăm (%)</option>
                                        <option value="fixed" <?php echo e(old('type', $coupon->type) == 'fixed' ? 'selected' : ''); ?>>Số tiền cố định (VND)</option>
                                    </select>
                                    <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="value" class="form-label">Giá trị <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="value" name="value" value="<?php echo e(old('value', $coupon->value)); ?>" 
                                           min="0" step="0.01" placeholder="0">
                                    <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted" id="valueHelp">
                                        Nhập giá trị giảm giá
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="minimum_order_amount" class="form-label">Đơn hàng tối thiểu</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['minimum_order_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="minimum_order_amount" name="minimum_order_amount" 
                                           value="<?php echo e(old('minimum_order_amount', $coupon->minimum_order_amount)); ?>" 
                                           min="0" placeholder="0">
                                    <?php $__errorArgs = ['minimum_order_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Để trống nếu không có yêu cầu tối thiểu</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="usage_limit" class="form-label">Giới hạn sử dụng tổng</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['usage_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="usage_limit" name="usage_limit" value="<?php echo e(old('usage_limit', $coupon->usage_limit)); ?>" 
                                           min="1" placeholder="Không giới hạn">
                                    <?php $__errorArgs = ['usage_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="usage_limit_per_user" class="form-label">Giới hạn sử dụng mỗi người</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['usage_limit_per_user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="usage_limit_per_user" name="usage_limit_per_user" 
                                           value="<?php echo e(old('usage_limit_per_user', $coupon->usage_limit_per_user)); ?>" 
                                           min="1" placeholder="Không giới hạn">
                                    <?php $__errorArgs = ['usage_limit_per_user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="starts_at" class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control <?php $__errorArgs = ['starts_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="starts_at" name="starts_at" 
                                           value="<?php echo e(old('starts_at', $coupon->starts_at->format('Y-m-d\TH:i'))); ?>">
                                    <?php $__errorArgs = ['starts_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expires_at" class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="expires_at" name="expires_at" 
                                           value="<?php echo e(old('expires_at', $coupon->expires_at->format('Y-m-d\TH:i'))); ?>">
                                    <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
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
                                      id="description" name="description" rows="3" 
                                      placeholder="Mô tả về mã giảm giá này..."><?php echo e(old('description', $coupon->description)); ?></textarea>
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
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       <?php echo e(old('is_active', $coupon->is_active) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">
                                    Kích hoạt mã giảm giá
                                </label>
                            </div>
                        </div>

                        <!-- Usage Statistics -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Thống kê sử dụng</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <small class="text-muted">Đã sử dụng:</small>
                                        <div class="fw-bold"><?php echo e($coupon->used_count); ?> lần</div>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Tạo lúc:</small>
                                        <div class="fw-bold"><?php echo e($coupon->created_at->format('d/m/Y H:i')); ?></div>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Cập nhật:</small>
                                        <div class="fw-bold"><?php echo e($coupon->updated_at->format('d/m/Y H:i')); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-secondary me-2">Hủy</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật mã giảm giá
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const valueHelp = document.getElementById('valueHelp');
    const codeInput = document.getElementById('code');
    
    // Update help text based on discount type
    function updateValueHelp() {
        if (typeSelect.value === 'percentage') {
            valueHelp.textContent = 'Nhập phần trăm giảm (VD: 20 cho 20%)';
        } else if (typeSelect.value === 'fixed') {
            valueHelp.textContent = 'Nhập số tiền giảm (VD: 50000 cho 50,000đ)';
        } else {
            valueHelp.textContent = 'Nhập giá trị giảm giá';
        }
    }
    
    // Initialize help text
    updateValueHelp();
    
    typeSelect.addEventListener('change', updateValueHelp);
    
    // Auto uppercase coupon code
    codeInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/coupons/edit.blade.php ENDPATH**/ ?>