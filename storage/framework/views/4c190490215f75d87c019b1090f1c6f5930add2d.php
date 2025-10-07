

<?php $__env->startSection('title', 'Đổi mật khẩu'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-user-circle"></i> Tài khoản của tôi</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?php echo e(route('profile.index')); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-user"></i> Thông tin cá nhân
                    </a>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-edit"></i> Chỉnh sửa thông tin
                    </a>
                    <a href="<?php echo e(route('profile.change-password')); ?>" class="list-group-item list-group-item-action active">
                        <i class="fas fa-lock"></i> Đổi mật khẩu
                    </a>
                    <a href="<?php echo e(route('orders.index')); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-lock"></i> Đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('profile.change-password.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="current_password" name="current_password" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('current_password')">
                                            <i class="fas fa-eye" id="current_password_icon"></i>
                                        </button>
                                    </div>
                                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="password" name="password" required minlength="8">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                            <i class="fas fa-eye" id="password_icon"></i>
                                        </button>
                                    </div>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">Mật khẩu phải có ít nhất 8 ký tự.</div>
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye" id="password_confirmation_icon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <a href="<?php echo e(route('profile.index')); ?>" class="btn btn-secondary me-2">Hủy</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Đổi mật khẩu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6><i class="fas fa-shield-alt"></i> Gợi ý bảo mật</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Sử dụng mật khẩu dài ít nhất 8 ký tự</li>
                        <li>Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                        <li>Không sử dụng thông tin cá nhân trong mật khẩu</li>
                        <li>Thường xuyên thay đổi mật khẩu</li>
                        <li>Không chia sẻ mật khẩu với người khác</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/frontend/profile/change-password.blade.php ENDPATH**/ ?>