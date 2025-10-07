<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Panel</title>
    
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
            transition: width 280ms cubic-bezier(.2,.8,.2,1), box-shadow 220ms ease;
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
            transition: margin-left 280ms cubic-bezier(.2,.8,.2,1);
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
            text-align: center;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .sidebar .sidebar-title { display: inline-block; }
        .sidebar.minimized .sidebar-title { display: none; }
    </style>
    @yield('styles')
    @stack('styles')
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
        padding: .35rem .6rem !important;
    }
</style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="p-3 d-flex align-items-center justify-content-between border-bottom border-secondary">
            <div class="d-flex align-items-center">
                <i class="fas fa-cogs text-white me-2"></i>
                <div class="sidebar-title text-white fw-bold">Admin Panel</div>
            </div>
            <div>
                <button class="btn btn-sm btn-outline-light" id="sidebar-minimize" title="Thu nhỏ menu">
                    <i class="fas fa-angle-double-left"></i>
                </button>
            </div>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> <span class="nav-label ms-2">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-list"></i> <span class="nav-label ms-2">Quản lý danh mục</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}" href="{{ route('admin.books.index') }}">
                    <i class="fas fa-book"></i> <span class="nav-label ms-2">Quản lý sách</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-cart"></i> <span class="nav-label ms-2">Quản lý đơn hàng</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                    <i class="fas fa-users"></i> <span class="nav-label ms-2">Quản lý khách hàng</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}">
                    <i class="fas fa-ticket-alt"></i> <span class="nav-label ms-2">Quản lý mã giảm giá</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                    <i class="fas fa-image"></i> <span class="nav-label ms-2">Quản lý banner</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}" href="{{ route('admin.statistics.index') }}">
                    <i class="fas fa-chart-line"></i> <span class="nav-label ms-2">Thống kê</span>
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home"></i> <span class="nav-label ms-2">Về trang chủ</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span class="nav-label ms-2">Đăng xuất</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
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
                <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
            </div>
            <div>
                <span class="text-muted">Xin chào, {{ Auth::user()->name }}</span>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Content -->
        <div class="content-wrapper">
            @yield('content')
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
    
    @yield('scripts')
    @stack('scripts')
</body>
</html>