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

        /* Ensure modals and popups are always clickable - override any animation issues */
        .modal,
        .modal-dialog,
        .modal-content,
        .modal-backdrop,
        .dropdown-menu,
        .popover,
        .tooltip,
        [role="dialog"],
        [aria-modal="true"] {
            animation: none !important;
            pointer-events: auto !important;
        }
        
        .modal.show {
            pointer-events: auto !important;
        }
        
        .modal-backdrop.show {
            pointer-events: auto !important;
        }

        /* Inter font for text elements - preserve icon fonts */
        body, html {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
            /* animation removed */
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
    
        .sidebar {
            /* Dark theme sidebar */
            background: linear-gradient(180deg, #071024 0%, #081226 100%);
            border-right: 1px solid rgba(255,255,255,0.04);
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 0 8px 30px rgba(2,6,23,0.6);
            /* animation removed */
            color: #cbd5e1;
        }
        
        .content-wrapper {
            margin-left: 250px;
            padding: 1.5rem;
            /* animation removed */
        }

        .sidebar-header h4 {
            font-size: 1.1rem;
        }
        
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 12px 16px;
            margin: 2px 8px;
            border-radius: 12px;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
            transition: left 0.45s ease;
            mix-blend-mode: screen;
        }
        
        @media (hover: hover) and (pointer: fine) {
            .sidebar .nav-link:hover {
                background: linear-gradient(135deg, rgba(99,102,241,0.10), rgba(59,130,246,0.08));
                color: #ffffff;
                transform: translateY(-2px) scale(1.02);
                box-shadow: 0 8px 30px rgba(2,6,23,0.6);
            }
                border-left: 4px solid rgba(99,102,241,0.95);
                padding-left: 12px;
            }

            .sidebar .nav-link:hover .nav-icon {
                color: #fff;
                transform: translateY(-1px) scale(1.05) rotate(4deg);
            }

            .sidebar .nav-link:hover:before {
                left: 100%;
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
             background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(79,70,229,0.14));
             color: #fff;
             transform: translateY(-1px);
             box-shadow: 0 6px 22px rgba(2,6,23,0.6);
         }
             background: linear-gradient(135deg, rgba(99,102,241,0.30), rgba(79,70,229,0.22));
             color: #fff;
             transform: translateY(-1px);
             box-shadow: 0 8px 28px rgba(59,130,246,0.18);
             border-left: 4px solid rgba(99,102,241,1);
             padding-left: 12px;
         }

         .sidebar .nav-link.active .nav-icon {
             color: #fff;
             transform: translateY(-1px) scale(1.06);
         }

         .nav-icon {
             width: 20px;
             height: 20px;
             margin-right: 12px;
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
         }

        .sidebar-header h4 {
            color: #e6eef8 !important;
            font-size: 1.1rem;
        }

        h1 { font-size: 1.65rem; /* animation removed */ }
        h2 { font-size: 1.4rem; /* animation removed */ }
        h3 { font-size: 1.2rem; /* animation removed */ }
        h4 { font-size: 1.05rem; /* animation removed */ }
        h5 { font-size: 0.95rem; /* animation removed */ }
        h6 { font-size: 0.9rem; /* animation removed */ }

        p, span, div, a, label {
            font-size: 0.95rem;
        }

        .btn, .btn-sm, .btn-lg {
            font-size: 0.95rem;
        }

        .form-control, .form-select, select {
            font-size: 0.95rem;
        }

        table {
            font-size: 0.95rem;
        }

        .card {
            /* animation removed */
        }

        .container-fluid {
            /* animation removed */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header p-4" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
            <div class="d-flex align-items-center">
                <svg class="nav-icon" style="margin-right: 8px; color: inherit;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <h4>Admin Panel</h4>
            </div>
        </div>
        <div class="p-2">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/categories') }}" class="nav-link">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Danh mục
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/books') }}" class="nav-link">
                        <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Sách
                    </a>
                </li>
            </ul>
        </div>
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
