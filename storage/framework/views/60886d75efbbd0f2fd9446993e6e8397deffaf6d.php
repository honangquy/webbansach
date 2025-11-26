

<?php $__env->startSection('content'); ?>
<?php $__env->startPush('styles'); ?>
<style>
    /* Enhanced Liquid Glass Background */
    .auth-bg {
        position: fixed;
        inset: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        /* Blend a warm/cool color gradient over the background image to increase vibrancy */
        background-image: linear-gradient(135deg, rgba(255,120,80,0.18), rgba(120,60,200,0.18)), url('https://mnismt.com/_next/static/media/background.ae46ac39.png');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        background-blend-mode: overlay;
        transform: scaleX(-1);
        /* boost color and contrast slightly for a punchier look */
        filter: saturate(1.25) contrast(1.05) brightness(1.02);
        -webkit-background-size: cover;
    }

    .auth-overlay {
        position: fixed;
        inset: 0;
        /* make overlay slightly lighter so the base image shows more color */
        background: linear-gradient(135deg, rgba(0,0,0,0.22), rgba(50,20,80,0.28));
        backdrop-filter: blur(4px) saturate(1.05);
        z-index: 1;
        mix-blend-mode: multiply;
    }

    /* Enhanced Glass Card with Liquid Glass Effect */
    .auth-card {
        max-width: 440px;
        margin: 8vh auto;
        position: relative;
        z-index: 2;
        border-radius: 24px;
        padding: 36px;
        
        /* Liquid glass effect */
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.25);
        
        /* Enhanced shadows for depth */
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35),
                    inset 0 1px 0 rgba(255, 255, 255, 0.5);
        
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .auth-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.45),
                    inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }

    .brand-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .brand-name {
        font-size: 1.6rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #e8e8e8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 2px 20px rgba(255, 255, 255, 0.3);
    }

    .auth-title {
        font-size: 1.75rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 8px;
        color: #ffffff;
        text-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
    }

    .auth-sub {
        text-align: center;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 28px;
        font-size: 0.95rem;
    }

    .input-with-icon {
        position: relative;
        margin-bottom: 20px;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        opacity: 0.85;
        z-index: 1;
    }

    .input-with-icon input {
        padding-left: 44px;
        padding-right: 16px;
        padding-top: 14px;
        padding-bottom: 14px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        	color: #ffffff;
        	font-size: 13px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-with-icon input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .input-with-icon input:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.45);
        box-shadow: 0 8px 32px rgba(255, 255, 255, 0.15);
    }

    .remember {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 13px;
    }

    .remember input[type=checkbox] {
        width: 18px;
        height: 18px;
        accent-color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
    }

    .small-link {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .small-link:hover {
        color: #ffffff;
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.2));
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #ffffff;
        padding: 14px 16px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .btn-primary-gradient:hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.3));
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(255, 255, 255, 0.25);
    }

    .auth-footer-link {
        text-align: center;
        margin-top: 20px;
        color: rgba(255, 255, 255, 0.85);
        font-size: 13px;
    }

    .auth-footer-link a {
        color: #ffffff;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
    }

    .auth-footer-link a:hover {
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
    }

    .text-danger {
        color: rgba(255, 100, 100, 1) !important;
        font-size: 13px;
        margin-top: 6px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .auth-card {
            margin: 6vh 18px;
            padding: 28px 22px;
        }
        .auth-title {
            font-size: 1.4rem;
        }
        .brand-name {
            font-size: 1.3rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<div class="auth-bg" aria-hidden="true"></div>
<div class="auth-overlay" aria-hidden="true"></div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="auth-card">
                <div class="brand-header">
                    <div class="brand-name">BookStore</div>
                </div>

                <h3 class="auth-title">Đăng nhập</h3>
                <div class="auth-sub">Đăng nhập để tiếp tục mua sắm tại HNQ</div>
                
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="input-with-icon">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path d="M3 7l9 6 9-6" />
                        </svg>
                        <input id="email" type="email" 
                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               name="email" 
                               value="<?php echo e(old('email')); ?>" 
                               required 
                               autocomplete="email" 
                               autofocus 
                               placeholder="Email của bạn">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger">
                                <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-with-icon">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="10" rx="2" />
                            <path d="M7 11V8a5 5 0 0110 0v3" />
                        </svg>
                        <input id="password" type="password" 
                               class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               name="password" 
                               required 
                               autocomplete="current-password" 
                               placeholder="Mật khẩu">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger">
                                <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <label class="remember">
                            <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                            Ghi nhớ đăng nhập
                        </label>
                        <?php if(Route::has('password.request')): ?>
                            <a class="small-link" href="<?php echo e(route('password.request')); ?>">Quên mật khẩu?</a>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary-gradient w-100">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </button>

                    <div class="auth-footer-link">
                        Chưa có tài khoản? <a href="<?php echo e(route('register')); ?>">Tạo tài khoản</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/auth/login.blade.php ENDPATH**/ ?>