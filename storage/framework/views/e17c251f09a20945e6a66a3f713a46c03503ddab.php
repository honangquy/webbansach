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
        /* Animation keyframes */
        @keyframes fadeInPage {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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
            animation: fadeInPage 0.5s ease-in-out;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-right: 1px solid #e2e8f0;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: width 280ms cubic-bezier(.2,.8,.2,1), box-shadow 220ms ease;
            animation: fadeInPage 0.5s ease-in-out;
        }
        
        .sidebar .nav-link {
            color: #475569;
            padding: 12px 16px;
            margin: 2px 8px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
            transition: left 0.5s;
        }
        
        /* Hover elevation effect: only on devices that support hover */
        @media (hover: hover) and (pointer: fine) {
            .sidebar .nav-link:hover {
                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
                color: white;
                transform: translateY(-2px) scale(1.02);
                box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            }

            .sidebar .nav-link:hover:before {
                left: 100%;
            }

            .sidebar .nav-link:hover .nav-icon {
                transform: rotate(5deg) scale(1.1);
            }

            .sidebar .nav-link:focus {
                outline: none;
                background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
                color: white;
                transform: translateY(-1px);
                box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
            }
        }
         
         .sidebar .nav-link.active {
             background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
             color: white;
             transform: translateY(-1px);
             box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
         }

         .nav-icon {
             width: 20px;
             height: 20px;
             margin-right: 12px;
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
         }
        
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #f8f9fa;
            transition: margin-left 280ms cubic-bezier(.2,.8,.2,1);
            animation: fadeInPage 0.5s ease-in-out 0.1s both;
        }
        
        .top-navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 0.85rem 1.5rem;
            margin-bottom: 2rem;
            animation: fadeInPage 0.5s ease-in-out 0.15s both;
        }

        .top-navbar h4 {
            font-size: 1.15rem;
            margin-bottom: 0;
        }

        .top-navbar .text-muted {
            font-size: 0.9rem;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            animation: fadeInPage 0.5s ease-in-out 0.2s both;
            font-size: 0.95rem;
        }
        
        .stats-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 10px;
            animation: fadeInPage 0.5s ease-in-out 0.25s both;
            font-size: 0.95rem;
        }
        
        .stats-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 10px;
            animation: fadeInPage 0.5s ease-in-out 0.3s both;
            font-size: 0.95rem;
        }
        
        .stats-card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            border-radius: 10px;
            animation: fadeInPage 0.5s ease-in-out 0.35s both;
            font-size: 0.95rem;
        }
        
        .content-wrapper {
            padding: 0 1.5rem 2rem 1.5rem;
            animation: fadeInPage 0.5s ease-in-out 0.2s both;
        }

        .content-wrapper > div {
            animation: fadeInPage 0.5s ease-in-out 0.25s both;
        }

        table {
            font-size: 0.95rem;
        }

        .btn, .btn-sm, .btn-lg {
            font-size: 0.95rem;
        }

        .form-control, .form-select, select {
            font-size: 0.95rem;
        }

        .alert {
            font-size: 0.95rem;
            animation: fadeInPage 0.4s ease-in-out;
        }

        .card {
            animation: fadeInPage 0.5s ease-in-out 0.3s both;
        }

        .card-title {
            font-size: 1.1rem;
        }

        .card-body {
            font-size: 0.95rem;
        }

        label, .label {
            font-size: 0.95rem;
        }

        h1 { font-size: 1.75rem; }
        h2 { font-size: 1.5rem; }
        h3 { font-size: 1.25rem; }
        h4 { font-size: 1.1rem; }
        h5 { font-size: 1rem; }
        h6 { font-size: 0.95rem; }
        
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
        /* Minimized sidebar styles */
        .sidebar.minimized {
            width: 70px;
            overflow: hidden;
        }

        .main-content.collapsed {
            margin-left: 70px;
        }

        /* Hide label text when minimized and center icons */
        .nav-label {
            display: inline-block;
            vertical-align: middle;
        }

        .sidebar.minimized .nav-label {
            display: none;
        }

        .sidebar.minimized .nav-link {
            justify-content: center;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .sidebar.minimized .nav-icon {
            margin-right: 0;
        }

        .sidebar .sidebar-title { 
            display: inline-block; 
        }
        
        .sidebar.minimized .sidebar-title { 
            display: none; 
        }

        .sidebar.minimized .d-flex {
            justify-content: center;
        }

        .sidebar.minimized .p-4 {
            padding: 1rem !important;
        }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</style>
<style>
    /* Fix oversized pagination chevrons/icons across vendor templates and themes.
       Some pages render SVG or icon fonts very large due to local rules; clamp them here
       so pagination previous/next arrows stay readable and consistent. */
    .pagination svg,
    .pagination .icon,
    .pagination i,
    .page-link svg,
    .page-link i,
    .ui.pagination .icon {
        width: 1em !important;
        height: 1em !important;
        font-size: 1em !important;
        vertical-align: middle !important;
        display: inline-block !important;
    }

    /* Ensure the small pagination controls keep reasonable padding */
    .pagination .page-link, .pagination a, .pagination span {
        line-height: 1;
        padding: .25rem .5rem !important;
        font-size: 0.95rem;
    }

    .pagination {
        animation: fadeInPage 0.5s ease-in-out 0.35s both;
    }
</style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="p-4 d-flex align-items-center justify-content-between" style="border-bottom: 1px solid #e2e8f0;">
            <div class="d-flex align-items-center">
                <svg class="nav-icon" style="margin-right: 8px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <div class="sidebar-title fw-bold" style="color: #1e293b; font-size: 1.1rem;">Admin Panel</div>
            </div>
            <div>
                <button class="btn btn-sm" id="sidebar-minimize" title="Thu nhỏ menu" style="border: 1px solid #e2e8f0; color: #64748b;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="p-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index')); ?>">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="nav-label">Quản lý danh mục</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.books.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.books.index')); ?>">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="nav-label">Quản lý sách</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index')); ?>">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="nav-label">Quản lý đơn hàng</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.customers.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.customers.index')); ?>">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="nav-label">Quản lý khách hàng</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.coupons.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.coupons.index')); ?>">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        <span class="nav-label">Quản lý mã giảm giá</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.banners.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.banners.index')); ?>">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="nav-label">Quản lý banner</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.statistics.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.statistics.index')); ?>">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="nav-label">Thống kê</span>
                    </a>
                </li>
                
                <li class="nav-item" style="margin-top: 1rem; border-top: 1px solid #e2e8f0; padding-top: 1rem;">
                    <a class="nav-link" href="<?php echo e(route('home')); ?>">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="nav-label">Về trang chủ</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('logout')); ?>"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="nav-label">Đăng xuất</span>
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>
            </ul>
        </div>
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
        
        // Sidebar minimize toggle (desktop) with persistence
        (function() {
            const btn = document.getElementById('sidebar-minimize');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');

            function setMinimized(min) {
                if (min) {
                    sidebar.classList.add('minimized');
                    mainContent.classList.add('collapsed');
                    btn.innerHTML = '<i class="fas fa-angle-double-right"></i>';
                } else {
                    sidebar.classList.remove('minimized');
                    mainContent.classList.remove('collapsed');
                    btn.innerHTML = '<i class="fas fa-angle-double-left"></i>';
                }
            }

            // Initialize from localStorage
            const stored = localStorage.getItem('admin_sidebar_minimized');
            if (stored === '1') setMinimized(true);

            btn?.addEventListener('click', function(e) {
                const isMin = sidebar.classList.contains('minimized');
                setMinimized(!isMin);
                localStorage.setItem('admin_sidebar_minimized', isMin ? '0' : '1');
            });
        })();
    </script>
    
    <?php echo $__env->yieldContent('scripts'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/layouts/admin.blade.php ENDPATH**/ ?>