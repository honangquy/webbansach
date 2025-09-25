<?php $__env->startSection('content'); ?>
<?php $__env->startPush('styles'); ?>
<style>
    /* Background image (flipped) and layout - same as login */
    .auth-bg { position: fixed; inset: 0; z-index: 0; width: 100%; height: 100%; background-image: url('https://i.pinimg.com/736x/a2/57/91/a2579145e96dcecfdf802b69e18611ea.jpg'); background-position: center center; background-repeat: no-repeat; background-size: cover; transform: scaleX(-1); filter: blur(3px) brightness(0.95) saturate(0.95); -webkit-background-size: cover; }
    .auth-overlay { position: fixed; inset: 0; background: linear-gradient(rgba(0,0,0,0.48), rgba(0,0,0,0.56)); backdrop-filter: blur(2px); z-index: 1; }
    .auth-card { max-width: 520px; margin: 6vh auto; position: relative; z-index: 2; border-radius: 1rem; box-shadow: 0 12px 40px rgba(2,6,23,0.28); padding: 28px; background: rgba(255,255,255,0.96); transition: transform .28s cubic-bezier(.2,.9,.2,1), box-shadow .28s; }
    .auth-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px rgba(2,6,23,0.2); }
    .auth-title { font-size: 1.5rem; font-weight:700; text-align:center; margin-bottom:8px; }
    .input-icon { position: absolute; left:12px; top:50%; transform:translateY(-50%); width:22px; height:22px; opacity:0.95 }
    .input-with-icon { position:relative }
    .input-with-icon input { padding-left:42px; border-radius:.6rem; transition:box-shadow .18s, border-color .18s; }
    .input-with-icon input:focus { box-shadow: 0 6px 18px rgba(37,100,255,0.12); border-color: #2f7efc; outline: none; }
    .btn-primary-gradient { background: linear-gradient(90deg,#1677ff,#2b9fff); border: none; color: #fff; padding:12px 16px; border-radius:.8rem; font-weight:700; transition: transform .15s, box-shadow .15s; }
    .btn-primary-gradient:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(39,107,255,0.18); }
    @media (max-width:768px){ .auth-card { margin: 8vh 16px; } .auth-title { font-size:1.2rem } }
</style>
<?php $__env->stopPush(); ?>

        <!-- Fullscreen background video: change the src to your video file in public/videos/ -->
        <div class="auth-bg" aria-hidden="true"></div>
        <div class="auth-overlay" aria-hidden="true"></div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="auth-card">
                <div class="mb-2" style="display:flex;align-items:center;justify-content:flex-start;gap:12px;">
                    <div style="font-size:1.4rem;font-weight:800;color:#0b63ff">HNQ BookStore</div>
                </div>

                <h3 class="auth-title">Tạo tài khoản</h3>
                <div class="auth-sub text-center" style="color:#556;margin-bottom:14px">Tạo tài khoản mới để quản lý đơn hàng và thanh toán nhanh hơn</div>

                <form method="POST" action="<?php echo e(route('register')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3 input-with-icon">
                        <!-- User icon -->
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus placeholder="Họ và tên">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3 input-with-icon">
                        <!-- Envelope icon -->
                        <!-- Redesigned envelope: rounded rect + flap adjusted to match password icon weight/size -->
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <rect x="2.8" y="6.6" width="18.4" height="11" rx="2.6" ry="2.6" fill="none" stroke="#6b7280" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" shape-rendering="geometricPrecision" />
                            <path d="M4.6 8.1 L12 13 L19.4 8.1" fill="none" stroke="#6b7280" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" shape-rendering="geometricPrecision" />
                        </svg>
                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" placeholder="Email của bạn">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3 input-with-icon">
                        <!-- Lock icon -->
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="10" rx="2" />
                            <path d="M7 11V8a5 5 0 0110 0v3" />
                        </svg>
                        <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="new-password" placeholder="Mật khẩu">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3 input-with-icon">
                        <!-- Lock icon (confirm) -->
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="10" rx="2" />
                            <path d="M7 11V8a5 5 0 0110 0v3" />
                        </svg>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Xác nhận mật khẩu">
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary-gradient w-100">Tạo tài khoản</button>
                    </div>

                    <div class="text-center mt-3 small">Đã có tài khoản? <a href="<?php echo e(route('login')); ?>">Đăng nhập</a></div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/auth/register.blade.php ENDPATH**/ ?>