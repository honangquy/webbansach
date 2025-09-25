<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> - HNQ BookStore</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome - V6.5.2 - Reliability and Fallback -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Custom CSS -->
    <style>
        /* Inter Font */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap');

        /* FontAwesome fallback - ensure icons show even if FA fails */
        .fa, .fas, .far, .fal, .fad, .fab {
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }
        
        /* Fallback for specific icons using Unicode */
        .fa-bookmark::before { content: "\f02e"; }
        .fa-book::before { content: "\f02d"; }
        .fa-book-open::before { content: "\f518"; }
        .fa-search::before { content: "\f002"; }
        .fa-shopping-cart::before { content: "\f07a"; }
        .fa-user::before { content: "\f007"; }
        .fa-phone::before { content: "\f095"; }
        .fa-envelope::before { content: "\f0e0"; }
        .fa-bars::before { content: "\f0c9"; } /* For navbar toggler */

        /* General */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa; /* Light gray background */
            font-family: 'Inter', sans-serif; /* Set Inter as the default font */
        }

        main {
            flex: 1;
        }

        /* Navbar improvements */
        .navbar {
            transition: background-color 0.3s ease-in-out;
        }

        .navbar-brand {
            font-weight: 700; /* Bolder brand */
            font-size: 1.5rem;
            color: #1a202c !important;
        }

        .nav-link {
            font-weight: 500;
            color: #4a5568 !important;
            transition: color 0.2s ease-in-out;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .nav-link:hover, .nav-link.active {
            color: #0d6efd !important; /* Bootstrap primary blue */
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0.5rem;
            right: 0.5rem;
            height: 2px;
            background-color: #0d6efd;
        }
        
        .search-form .form-control {
            border-radius: 20px;
            border-right: 0;
            border-color: #ced4da;
        }
        
        .search-form .btn {
            border-radius: 20px;
            border-left: 0;
            margin-left: -40px;
            z-index: 10;
            background: transparent;
            color: #6c757d;
            border: none;
        }
        .search-form .btn:hover {
            color: #0d6efd;
        }

        .navbar-nav .nav-item.dropdown {
            position: relative;
        }

        .navbar-nav .dropdown-menu {
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            position: absolute; /* Ensure absolute positioning */
        }

        .dropdown-menu-end {
            right: 0;
            left: auto;
        }

        .dropdown-item {
            font-weight: 500;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: #1a202c;
        }

        .cart-badge {
            background-color: #dc3545;
            border-radius: 50%;
            font-size: 0.75rem;
            padding: 0.25em 0.5em;
        }

        /* Footer */
        .footer {
            background-color: #2c3e50;
            color: white;
            margin-top: auto;
        }
        
        /* Book card */
        .book-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            height: 100%;
            border: 1px solid #e9ecef;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: #0d6efd;
        }

        .book-card .card-img-top {
            transition: transform 0.3s ease;
        }

        .book-card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        .book-card .card-title {
            transition: color 0.3s ease;
        }

        .book-card:hover .card-title {
            color: #0d6efd;
        }
        
        .price {
            color: #e74c3c;
            font-weight: bold;
        }
        
        .sale-price {
            color: #27ae60;
            font-weight: bold;
        }
        
        .original-price {
            text-decoration: line-through;
            color: #7f8c8d;
        }

        /* Category card hover effect */
        .category-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Smoother, bouncier transition */
            overflow: hidden;
            border-radius: 12px !important;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 200px;
            position: relative;
        }
        
        .category-card:hover {
            transform: translateY(-15px) scale(1.05) rotate(2deg); /* More dramatic transform */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 20px rgba(13, 110, 253, 0.3); /* Added a blue glow effect */
        }
        
        .category-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
            transition: background 0.4s ease; /* Add transition for the overlay */
        }

        .category-card:hover .category-overlay {
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.2) 100%); /* Overlay becomes more transparent on hover */
        }
        
        .category-overlay::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                repeating-linear-gradient(
                    0deg,
                    transparent 0px,
                    transparent 2px,
                    rgba(255, 255, 255, 0.03) 2px,
                    rgba(255, 255, 255, 0.03) 4px
                );
            animation: glitch 3s infinite;
        }
        
        @keyframes glitch {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 0.9; }
            51% { opacity: 0.7; transform: translateX(1px); }
            52% { transform: translateX(0); }
        }
        
        .z-index-2 {
            z-index: 2;
        }
        
        /* Category Background Images - Dark Fantasy Theme */
        .category-novel {
            background-image: url('https://i.pinimg.com/1200x/57/72/fd/5772fd4e3cdf9cec704b64739c097c90.jpg');
        }
        
        .category-business {
            background-image: url('https://i.pinimg.com/736x/76/dc/dd/76dcdd24315f9fc155396bcb0a858c70.jpg');
        }
        
        .category-psychology {
            background-image: url('https://i.pinimg.com/736x/50/ab/18/50ab181f22fbf623adb65a2b80a0a321.jpg');
        }
        
        .category-children {
            background-image: url('https://i.pinimg.com/1200x/dd/8a/c4/dd8ac4dc8108f0d9911ea1b331d3625b.jpg');
        }
        
        .category-default {
            background-image: url('https://i.pinimg.com/736x/23/e1/2d/23e12df4be67b02968344ad30c005775.jpg');
        }
        
        /* Additional Categories for the 8 displayed */
        .category-education {
            background-image: url('https://i.pinimg.com/736x/bc/77/3c/bc773cf47ea49376630b2b40a84af4cd.jpg');
        }
        
        .category-science {
            background-image: url('https://i.pinimg.com/originals/74/6d/ea/746dea36bff8a01b81df3adc03b4f073.jpg');
        }
        
        .category-vietnamese-literature {
            background-image: url('https://i.pinimg.com/736x/9d/0b/9c/9d0b9cfa14eb2144ed7570b5f389eabf.jpg');
        }
        
        .category-history {
            background-image: url('https://i.pinimg.com/736x/67/16/18/671618bdcc9aad67f7f3ee0e4ed8adf2.jpg');
        }
        
        .category-card:hover .category-overlay::after {
            animation: glitch-intense 1.5s infinite;
        }
        
        @keyframes glitch-intense {
            0%, 100% { opacity: 0.8; transform: translateX(0); }
            25% { opacity: 0.6; transform: translateX(-2px); }
            50% { opacity: 0.9; transform: translateX(2px); }
            75% { opacity: 0.7; transform: translateX(-1px); }
        }
        
        /* Remove old SVG styles */
        .category-card svg {
            display: none;
        }
        
        /* Remove old dark fantasy image styles */
        .dark-fantasy-image {
            display: none;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
    
    <!-- Remove the aggressive font override -->
    <style>
        /* All font styles are now handled by the body font-family and Bootstrap defaults */
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                 HNQ BookStore
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left Menu -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('books.*') ? 'active' : ''); ?>" href="<?php echo e(route('books.index')); ?>">Sách</a>
                    </li>
                </ul>
                
                <!-- Search Form -->
                <form class="d-flex me-3 search-form" method="GET" action="<?php echo e(route('books.index')); ?>">
                    <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm sách..." value="<?php echo e(request('search')); ?>">
                    <button class="btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <!-- Right Menu -->
                <ul class="navbar-nav">
                    <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">Đăng ký</a>
                        </li>
                    <?php else: ?>
                        <!-- Cart -->
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="<?php echo e(route('cart.index')); ?>">
                                <i class="fas fa-shopping-cart"></i>
                                <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill cart-badge">
                                    0
                                </span>
                            </a>
                        </li>
                        
                        <!-- User Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo e(Auth::user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.index')); ?>">
                                    <i class="fas fa-user"></i> Thông tin cá nhân
                                </a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                    <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
                                </a></li>
                                <?php if(Auth::user()->isAdmin()): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                                        <i class="fas fa-cogs"></i> Quản trị
                                    </a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </a>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>HNQ BookStore</h5>
                    <p>Sách gì cũng có, mua hết ở shop tui :<</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo e(route('home')); ?>" class="text-light">Trang chủ</a></li>
                        <li><a href="#" class="text-light">Sách</a></li>
                        <li><a href="#" class="text-light">Về chúng tôi</a></li>
                        <li><a href="#" class="text-light">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p><i class="fas fa-phone"></i> 0343935487</p>
                    <p><i class="fas fa-envelope"></i> hoquy902@gmail.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> Tân Bình, Tp HCM</p>
                </div>
            </div>
            <hr class="text-light">
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; <?php echo e(date('Y')); ?> HNQ BookStore. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Global Cart Script -->
    <script>
        $(document).ready(function() {
            // Load cart count on page load
            loadCartCount();
        });
        
        function loadCartCount() {
            $.get('<?php echo e(route("cart.count")); ?>', function(response) {
                $('.cart-badge').text(response.cart_count);
            });
        }
        
        // Global add to cart function
        window.addToCart = function(bookId, quantity = 1) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: '<?php echo e(route("cart.add")); ?>',
                method: 'POST',
                data: {
                    book_id: bookId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        $('.cart-badge').text(response.cart_count);
                        
                        // Show success message
                        showGlobalAlert('success', response.message);
                    } else {
                        showGlobalAlert('error', response.message);
                    }
                },
                error: function() {
                    showGlobalAlert('error', 'Có lỗi xảy ra, vui lòng thử lại!');
                }
            });
        };
        
        // Global alert function
        window.showGlobalAlert = function(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 10000; min-width: 300px;">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            $('body').append(alertHtml);
            
            // Auto dismiss after 3 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);
        };
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>