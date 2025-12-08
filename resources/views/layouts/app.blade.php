<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Fonts - Inter only -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Inter Font CSS -->
    <link rel="stylesheet" href="{{ asset('css/inter-font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/force-inter.css') }}">
    
    <!-- Custom CSS for Inter font -->
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        }
    </style>
    
    <!-- Per-page styles -->
    @stack('styles')
    
    <!-- FINAL INTER FONT OVERRIDE - MAXIMUM PRIORITY -->
    <style>
        /* Force Inter font with highest specificity possible */
        html, html *, html *:before, html *:after,
        body, body *, body *:before, body *:after,
        div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video, input, textarea, select, button {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        }
        
        /* Bootstrap overrides */
        .btn, .form-control, .card, .navbar, .nav, .dropdown-menu, .modal, .alert, .badge, .breadcrumb, .carousel, .collapse, .dropdown, .list-group, .pagination, .popover, .progress, .tooltip {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Modern Dark Navigation Bar -->
        <style>
            .modern-nav {
                background: linear-gradient(180deg, #0c0c1d 0%, #12122a 100%);
                border-bottom: 1px solid rgba(255,255,255,0.06);
                padding: 0;
                position: sticky;
                top: 0;
                z-index: 1030;
            }
            .modern-nav .nav-container {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 24px;
                height: 60px;
            }
            /* Left: Nav Links */
            .modern-nav .nav-links {
                display: flex;
                align-items: center;
                gap: 8px;
                list-style: none;
                margin: 0;
                padding: 0;
            }
            .modern-nav .nav-links a {
                color: rgba(255,255,255,0.75);
                text-decoration: none;
                font-size: 13px;
                font-weight: 500;
                padding: 8px 16px;
                border-radius: 8px;
                transition: all 0.22s ease;
                white-space: nowrap;
            }
            .modern-nav .nav-links a:hover {
                color: #fff;
                background: rgba(255,255,255,0.08);
            }
            /* Center: Logo */
            .modern-nav .nav-brand {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
            }
            .modern-nav .nav-brand .brand-icon {
                width: 28px;
                height: 28px;
                background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .modern-nav .nav-brand .brand-icon svg {
                width: 16px;
                height: 16px;
                color: #fff;
            }
            .modern-nav .nav-brand .brand-text {
                font-size: 18px;
                font-weight: 800;
                color: #fff;
                letter-spacing: -0.5px;
            }
            .modern-nav .nav-brand .brand-text span {
                color: #a855f7;
            }
            /* Right: Icons / Auth */
            .modern-nav .nav-actions {
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .modern-nav .nav-icon-btn {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                background: transparent;
                border: none;
                color: rgba(255,255,255,0.7);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.22s ease;
                text-decoration: none;
            }
            .modern-nav .nav-icon-btn:hover {
                background: rgba(255,255,255,0.08);
                color: #fff;
            }
            .modern-nav .nav-icon-btn svg {
                width: 20px;
                height: 20px;
            }
            /* User dropdown */
            .modern-nav .user-dropdown {
                position: relative;
            }
            .modern-nav .user-btn {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 6px 12px;
                background: rgba(255,255,255,0.06);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 10px;
                color: rgba(255,255,255,0.85);
                font-size: 13px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.22s ease;
                text-decoration: none;
            }
            .modern-nav .user-btn:hover {
                background: rgba(255,255,255,0.1);
                color: #fff;
            }
            .modern-nav .user-avatar {
                width: 26px;
                height: 26px;
                border-radius: 50%;
                background: linear-gradient(135deg, #7c3aed, #a855f7);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: 11px;
                font-weight: 700;
            }
            .modern-nav .dropdown-menu {
                background: #1a1a2e;
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 12px;
                padding: 8px;
                min-width: 200px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            }
            .modern-nav .dropdown-menu .dropdown-item {
                color: rgba(255,255,255,0.8);
                font-size: 13px;
                padding: 10px 14px;
                border-radius: 8px;
                transition: all 0.2s ease;
            }
            .modern-nav .dropdown-menu .dropdown-item:hover {
                background: rgba(255,255,255,0.08);
                color: #fff;
            }
            .modern-nav .dropdown-menu .dropdown-divider {
                border-color: rgba(255,255,255,0.08);
                margin: 6px 0;
            }
            /* Mobile hamburger */
            .modern-nav .mobile-toggle {
                display: none;
                width: 40px;
                height: 40px;
                border: none;
                background: transparent;
                color: rgba(255,255,255,0.8);
                cursor: pointer;
                border-radius: 8px;
                align-items: center;
                justify-content: center;
            }
            .modern-nav .mobile-toggle:hover {
                background: rgba(255,255,255,0.08);
            }
            .modern-nav .mobile-toggle svg {
                width: 22px;
                height: 22px;
            }
            /* Mobile menu */
            .modern-nav .mobile-menu {
                display: none;
                position: absolute;
                top: 60px;
                left: 0;
                right: 0;
                background: #0c0c1d;
                border-bottom: 1px solid rgba(255,255,255,0.06);
                padding: 16px 24px;
                flex-direction: column;
                gap: 8px;
            }
            .modern-nav .mobile-menu.show {
                display: flex;
            }
            .modern-nav .mobile-menu a {
                color: rgba(255,255,255,0.8);
                text-decoration: none;
                font-size: 14px;
                font-weight: 500;
                padding: 12px 16px;
                border-radius: 10px;
                transition: all 0.2s ease;
            }
            .modern-nav .mobile-menu a:hover {
                background: rgba(255,255,255,0.08);
                color: #fff;
            }
            /* Responsive */
            @media (max-width: 768px) {
                .modern-nav .nav-links {
                    display: none;
                }
                .modern-nav .nav-brand {
                    position: static;
                    transform: none;
                }
                .modern-nav .mobile-toggle {
                    display: flex;
                }
                .modern-nav .nav-container {
                    padding: 0 16px;
                }
            }
            @media (min-width: 769px) {
                .modern-nav .mobile-menu {
                    display: none !important;
                }
            }
        </style>

        <nav class="modern-nav">
            <div class="nav-container">
                <!-- Left: Nav Links (Desktop) -->
                <ul class="nav-links">
                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li><a href="{{ route('books.index') }}">Sách</a></li>
                    <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                </ul>

                <!-- Center: Logo -->
                <a class="nav-brand" href="{{ url('/') }}">
                    <div class="brand-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </div>
                    <span class="brand-text">Book<span>Store</span></span>
                </a>

                <!-- Right: Actions -->
                <div class="nav-actions">
                    <!-- Search Icon -->
                    <a href="{{ route('books.index') }}" class="nav-icon-btn" title="Tìm kiếm">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                    </a>

                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="nav-icon-btn" title="Giỏ hàng">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </a>

                    @guest
                        <!-- Login Icon -->
                        <a href="{{ route('login') }}" class="nav-icon-btn" title="Đăng nhập">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </a>
                    @else
                        <!-- User Dropdown -->
                        <div class="user-dropdown dropdown">
                            <a class="user-btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                <span class="d-none d-md-inline">{{ Str::limit(Auth::user()->name, 12) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                                        <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                        Thông tin cá nhân
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                                            <line x1="3" y1="6" x2="21" y2="6"/>
                                            <path d="M16 10a4 4 0 0 1-8 0"/>
                                        </svg>
                                        Đơn hàng của tôi
                                    </a>
                                </li>
                                @if(Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="7" height="7"/>
                                            <rect x="14" y="3" width="7" height="7"/>
                                            <rect x="14" y="14" width="7" height="7"/>
                                            <rect x="3" y="14" width="7" height="7"/>
                                        </svg>
                                        Quản trị
                                    </a>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                            <polyline points="16,17 21,12 16,7"/>
                                            <line x1="21" y1="12" x2="9" y2="12"/>
                                        </svg>
                                        Đăng xuất
                                    </a>
                                </li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    @endguest

                    <!-- Mobile Toggle -->
                    <button class="mobile-toggle" onclick="document.querySelector('.mobile-menu').classList.toggle('show')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="12" x2="21" y2="12"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu">
                <a href="{{ url('/') }}">Trang chủ</a>
                <a href="{{ route('books.index') }}">Sách</a>
                <a href="{{ route('cart.index') }}">Giỏ hàng</a>
                @guest
                    <a href="{{ route('login') }}">Đăng nhập</a>
                    <a href="{{ route('register') }}">Đăng ký</a>
                @else
                    <a href="{{ route('profile.index') }}">Thông tin cá nhân</a>
                    <a href="{{ route('orders.index') }}">Đơn hàng của tôi</a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}">Quản trị</a>
                    @endif
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
                @endguest
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
