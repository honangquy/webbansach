<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> - Admin Panel</title>
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome - Latest version -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Inter font for text elements - preserve icon fonts */
        body, html {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        }
        
        /* Apply Inter to common text elements */
        h1, h2, h3, h4, h5, h6, p, span, div, a, button, input, textarea, select, label {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        }
        
        /* Preserve Font Awesome icons */
        .fa, .fas, .far, .fal, .fab, .fad, .fass, .fasr, .fasl, 
        [class*="fa-"], [class^="fa-"], i[class*="fa"], i[class^="fa"] {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands", "FontAwesome" !important;
        }
        
        /* Preserve other icon fonts */
        .glyphicon, [class*="glyphicon-"], [class^="glyphicon-"] {
            font-family: 'Glyphicons Halflings' !important;
        }
    </style>
    <!-- AdminLTE Style -->
    <style>
        body {
            font-family: Inter, "Inter Placeholder", sans-serif !important;
        }
        
        .sidebar {
            background-color: #2c3e50;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            perspective: 1000px; /* enable 3D transforms for children */
        }
        
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 15px 20px;
            border-bottom: 1px solid #34495e;
            border-radius: 8px;
            transition: transform 220ms cubic-bezier(.2,.8,.2,1), box-shadow 220ms ease, background-color 180ms;
            transform-origin: center center;
            will-change: transform, box-shadow;
            backface-visibility: hidden;
            box-shadow: none;
            display: block;
        }
        
        /* Hover elevation effect: only on devices that support hover */
        @media (hover: hover) and (pointer: fine) {
            .sidebar .nav-link:hover {
                background-color: #34495e;
                color: white;
                transform: translateY(-6px) rotateX(3deg);
                box-shadow: 0 12px 30px rgba(0,0,0,0.28);
            }

            .sidebar .nav-link:focus {
                outline: none;
                transform: translateY(-4px) rotateX(2deg);
                box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            }
        }
         
         .sidebar .nav-link.active {
             background-color: #3498db;
             color: white;
            transform: translateY(-6px) rotateX(3deg);
            box-shadow: 0 12px 30px rgba(0,0,0,0.28);
         }
        
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .top-navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            margin-bottom: 2rem;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        
        .stats-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 10px;
        }
        
        .stats-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 10px;
        }
        
        .stats-card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            border-radius: 10px;
        }
        
        .content-wrapper {
            padding: 0 2rem 2rem 2rem;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
                transition: margin-left 0.3s;
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="p-3 text-center border-bottom border-secondary">
            <h4 class="text-white">
                <i class="fas fa-cogs"></i> Admin Panel
            </h4>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index')); ?>">
                    <i class="fas fa-list me-2"></i> Quản lý danh mục
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('admin.books.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.books.index')); ?>">
                    <i class="fas fa-book me-2"></i> Quản lý sách
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index')); ?>">
                    <i class="fas fa-shopping-cart me-2"></i> Quản lý đơn hàng
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('admin.customers.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.customers.index')); ?>">
                    <i class="fas fa-users me-2"></i> Quản lý khách hàng
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('admin.coupons.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.coupons.index')); ?>">
                    <i class="fas fa-ticket-alt me-2"></i> Quản lý mã giảm giá
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('admin.statistics.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.statistics.index')); ?>">
                    <i class="fas fa-chart-line me-2"></i> Thống kê
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <a class="nav-link" href="<?php echo e(route('home')); ?>">
                    <i class="fas fa-home me-2"></i> Về trang chủ
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('logout')); ?>"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                    <?php echo csrf_field(); ?>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-link d-md-none" id="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h4>
            </div>
            <div>
                <span class="text-muted">Xin chào, <?php echo e(Auth::user()->name); ?></span>
            </div>
        </div>

        <!-- Alerts -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    </script>
    
    <?php echo $__env->yieldContent('scripts'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/layouts/admin.blade.php ENDPATH**/ ?>