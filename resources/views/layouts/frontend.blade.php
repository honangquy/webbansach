<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - HNQ BookStore</title>
    
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
            padding-top: 0 !important; /* Remove default padding since navbar is centered */
        }

        main {
            flex: 1;
            padding-top: 1rem;
        }

        /* Navbar improvements - Centered Floating Navbar (Flat semi-transparent blue) */

        /* Slimmer centered navbar */
        .navbar {
            background-color: rgba(33, 150, 243, 0.65) !important;
            backdrop-filter: blur(10px) saturate(110%) !important;
            -webkit-backdrop-filter: blur(10px) saturate(110%) !important;
            box-shadow: 0 6px 22px rgba(13, 71, 161, 0.10) !important;
            border: 1px solid rgba(33, 150, 243, 0.10) !important;
            border-radius: 12px !important; /* slightly smaller radius */
            margin: 0.6rem auto !important; /* less vertical spacing */
            max-width: 98% !important;
            transition: all 0.2s ease-in-out;
        }

        .navbar .container-fluid {
            padding: 0.22rem 1rem; /* reduced vertical padding to lower navbar height */
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.25rem; /* slightly smaller to help reduce height */
            color: rgba(255,255,255,0.98) !important;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.14);
            letter-spacing: 0.2px;
            padding-top: 0.08rem; padding-bottom: 0.08rem;
            line-height: 1;
        }

        .nav-link {
            font-weight: 700;
            color: rgba(255,255,255,0.95) !important;
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            padding: 0.28rem 0.6rem; /* tighter vertical/horizontal padding */
            border-radius: 6px;
            margin: 0 0.15rem;
            font-size: 0.92rem; /* slightly smaller text */
            line-height: 1.1;
        }

        .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255,255,255,0.06);
            transform: translateY(-1px);
        }

        .nav-link.active {
            color: #ffffff !important;
            background: rgba(255,255,255,0.09);
            box-shadow: 0 2px 8px rgba(255,255,255,0.06);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: rgba(255,255,255,0.9);
            border-radius: 2px;
        }
        
        .search-form .form-control {
            border-radius: 20px;
            border: 1px solid rgba(255, 193, 7, 0.28);
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(8px);
            padding: 0.35rem 0.85rem; /* smaller input height */
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        
        .search-form .form-control:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15);
            background: rgba(255, 255, 255, 0.9);
        }
        
        .search-form .btn {
            border-radius: 20px;
            margin-left: -36px; /* tighter overlap with input */
            z-index: 10;
            background: transparent;
            color: #8b6914;
            border: none;
            transition: all 0.2s ease;
            padding: 0.28rem 0.5rem;
        }
        
        .search-form .btn:hover {
            color: #6b5416;
            transform: scale(1.1);
        }

        .navbar-nav .nav-item.dropdown {
            position: relative;
        }

        .navbar-nav .dropdown-menu {
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            position: absolute;
            margin-top: 0.5rem;
        }

        .dropdown-menu-end {
            right: 0;
            left: auto;
        }
        
        .dropdown-item {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0.2rem 0.5rem;
        }
        
        .dropdown-item:hover {
            background: rgba(255, 193, 7, 0.15);
            color: #8b6914;
            transform: translateX(5px);
        }

        /* Cart badge style */
        .badge.bg-danger {
            background: linear-gradient(135deg, #ff9800, #ffc107) !important;
            box-shadow: 0 2px 8px rgba(255, 152, 0, 0.4);
        }

        /* Navbar toggler for mobile */
        .navbar-toggler {
            border-color: rgba(139, 105, 20, 0.3);
            color: #8b6914;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(139, 105, 20, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
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
    @stack('styles')

    <!-- Navbar responsive tweaks -->
    <style>
        /* Responsive adjustments for centered navbar */
        @media (max-width: 1200px) {
            .navbar {
                max-width: 98% !important;
                margin: 0.5rem auto !important;
            }
        }
        
        /* Slightly smaller brand on tablets/phones */
        @media (max-width: 991.98px) {
            .navbar-brand { font-size: 1.25rem !important; }
            .navbar {
                max-width: 98% !important;
                margin: 0.5rem auto !important;
                border-radius: 16px !important;
            }
        }

        /* When navbar collapses on smaller screens, make the collapse area more usable */
        @media (max-width: 991.98px) {
            .navbar-collapse { 
                padding: 0.65rem 1rem; 
                background: rgba(255, 255, 255, 0.9);
                border-radius: 12px;
                margin-top: 0.5rem;
            }
            .search-form { width:100%; display:flex; margin: .5rem 0; }
            .search-form .form-control { flex:1; width: 100%; }
            .search-form .btn { margin-left: .5rem; }
            .navbar-nav.me-auto { width:100%; }
            .navbar-nav.me-auto .nav-item { width:100%; }
            .navbar-nav.me-auto .nav-link { padding:.5rem 0.75rem; }
            .navbar-nav { align-items: stretch; }
            .navbar-nav .nav-item { text-align:left; }
            /* Make dropdown menus full width inside collapsed navbar */
            .navbar-nav .dropdown-menu { position: static; float: none; width: 100%; box-shadow: none; border: none; }
        }

        /* Adjust cart badge on very small screens */
        @media (max-width: 576px) {
            .cart-badge { right: -6px !important; top: 6px !important; transform: none !important; }
            .search-form .btn { margin-left: 6px; }
        }
    </style>

    <!-- Clamp pagination and SVG/icon sizes to avoid oversized chevrons -->
    <style>
        .pagination svg,
        .pagination i,
        .page-link svg,
        .page-link i,
        .ui.pagination .icon,
        .ui.pagination i {
            width: 1em !important;
            height: 1em !important;
            font-size: 1em !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }

        .pagination .page-link, .pagination a, .pagination span {
            line-height: 1;
            padding: .35rem .6rem !important;
        }
    </style>

    <!-- Remove the aggressive font override -->
    <style>
        /* All font styles are now handled by the body font-family and Bootstrap defaults */
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                 HNQ BookStore
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left Menu -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">Sách</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Liên hệ</a>
                    </li>
                </ul>
                
                <!-- Search Form -->
                <form class="d-flex me-3 search-form" method="GET" action="{{ route('books.index') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm sách..." value="{{ request('search') }}">
                    <button class="btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <!-- Right Menu -->
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
                        </li>
                    @else
                        <!-- Cart -->
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill cart-badge">
                                    0
                                </span>
                            </a>
                        </li>
                        
                        <!-- User Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="fas fa-user"></i> Thông tin cá nhân
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
                                </a></li>
                                @if(Auth::user()->isAdmin() || (method_exists(Auth::user(), 'isStaff') && Auth::user()->isStaff()))
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cogs"></i> Quản trị
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
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
                        <li><a href="{{ route('home') }}" class="text-light">Trang chủ</a></li>
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
                    <p>&copy; {{ date('Y') }} HNQ BookStore. All rights reserved.</p>
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
            $.get('{{ route("cart.count") }}', function(response) {
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
                url: '{{ route("cart.add") }}',
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
    
    @stack('scripts')
</body>
</html>