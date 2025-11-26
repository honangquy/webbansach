

<?php $__env->startSection('title', 'Thông tin cá nhân'); ?>

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
                    <a href="<?php echo e(route('profile.index')); ?>" class="list-group-item list-group-item-action active">
                        <i class="fas fa-user"></i> Thông tin cá nhân
                    </a>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-edit"></i> Chỉnh sửa thông tin
                    </a>
                    <a href="<?php echo e(route('profile.change-password')); ?>" class="list-group-item list-group-item-action">
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
            <!-- Profile Info -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-user"></i> Thông tin cá nhân</h5>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <?php if($user->avatar): ?>
                                <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" 
                                     alt="Avatar" class="img-fluid rounded-circle mb-3" 
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                                     style="width: 120px; height: 120px;">
                                    <i class="fas fa-user fa-3x text-white"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Họ và tên:</strong></td>
                                    <td><?php echo e($user->name); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td><?php echo e($user->email); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Số điện thoại:</strong></td>
                                    <td><?php echo e($user->phone ?: 'Chưa cập nhật'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Địa chỉ:</strong></td>
                                    <td><?php echo e($user->address ?: 'Chưa cập nhật'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Ngày sinh:</strong></td>
                                    <td>
                                        <?php if($user->date_of_birth): ?>
                                            <?php echo e(\Carbon\Carbon::parse($user->date_of_birth)->format('d/m/Y')); ?>

                                        <?php else: ?>
                                            Chưa cập nhật
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Ngày đăng ký:</strong></td>
                                    <td><?php echo e($user->created_at->format('d/m/Y H:i')); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-shopping-bag"></i> Đơn hàng gần đây</h5>
                    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-primary btn-sm">
                        Xem tất cả
                    </a>
                </div>
                <div class="card-body">
                    <?php if($orders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><strong>#<?php echo e($order->id); ?></strong></td>
                                        <td><?php echo e($order->created_at->format('d/m/Y')); ?></td>
                                        <td><?php echo e(number_format($order->final_amount ?? $order->total_amount)); ?>đ</td>
                                        <td>
                                            <?php switch($order->status):
                                                case ('pending'): ?>
                                                    <span class="badge bg-warning">Chờ xử lý</span>
                                                    <?php break; ?>
                                                <?php case ('confirmed'): ?>
                                                    <span class="badge bg-info">Đã xác nhận</span>
                                                    <?php break; ?>
                                                <?php case ('shipping'): ?>
                                                    <span class="badge bg-primary">Đang giao</span>
                                                    <?php break; ?>
                                                <?php case ('delivered'): ?>
                                                    <span class="badge bg-success">Đã giao</span>
                                                    <?php break; ?>
                                                <?php case ('cancelled'): ?>
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                    <?php break; ?>
                                            <?php endswitch; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('orders.show', $order->id)); ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                Xem chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-primary">
                                Mua sắm ngay
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
<script>
    alert('<?php echo e(session('success')); ?>');
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/frontend/profile/index.blade.php ENDPATH**/ ?>