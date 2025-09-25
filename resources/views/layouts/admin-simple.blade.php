<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Panel</title>
    
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
    
    <style>
        .sidebar {
            background-color: #2c3e50;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }
        
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }
        
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
            transition: transform 220ms cubic-bezier(.2,.8,.2,1), box-shadow 220ms ease, background-color 180ms;
            transform-origin: center center;
            will-change: transform, box-shadow;
            backface-visibility: hidden;
            display: block;
        }
        
        @media (hover: hover) and (pointer: fine) {
            .sidebar .nav-link:hover {
                background-color: #34495e;
                color: #ffffff;
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
             color: #ffffff;
            transform: translateY(-6px) rotateX(3deg);
            box-shadow: 0 12px 30px rgba(0,0,0,0.28);
         }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header p-3">
            <h4 class="text-white">Admin Panel</h4>
        </div>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ url('admin/dashboard') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/categories') }}" class="nav-link">
                    <i class="fas fa-list me-2"></i> Danh mục
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/books') }}" class="nav-link">
                    <i class="fas fa-book me-2"></i> Sách
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4">@yield('page-title')</h1>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>