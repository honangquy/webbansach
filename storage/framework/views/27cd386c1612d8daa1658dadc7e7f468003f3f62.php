<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> - BookStore</title>
    
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
            font-size: 14px; /* Base font size - reduced from default 16px */
        }

        /* Headings - reduced sizes */
        h1 { font-size: 1.75rem; } /* ~28px */
        h2 { font-size: 1.5rem; }  /* ~24px */
        h3 { font-size: 1.25rem; } /* ~20px */
        h4 { font-size: 1.1rem; }  /* ~17.6px */
        h5 { font-size: 1rem; }    /* ~16px */
        h6 { font-size: 0.95rem; } /* ~15.2px */

        /* Buttons - consistent sizing */
        .btn {
            font-size: 14px;
        }
        .btn-sm {
            font-size: 13px;
        }
        .btn-lg {
            font-size: 15px;
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
            font-size: 1.1rem; /* Reduced from 1.25rem */
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
            font-size: 13px; /* Fixed 13px */
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
            font-size: 13px; /* Reduced for compact cards */
            line-height: 1.3;
            min-height: 35px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-card:hover .card-title {
            color: #0d6efd;
        }
        
        /* Custom 5-column grid for XL screens */
        @media (min-width: 1200px) {
            .col-xl-2-4 {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }
        
        .book-card .card-text {
            font-size: 13px; /* Book details text */
        }
        
        .price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 15px;
        }
        
        .sale-price {
            color: #27ae60;
            font-weight: bold;
            font-size: 15px;
        }
        
        .original-price {
            text-decoration: line-through;
            color: #7f8c8d;
            font-size: 13px;
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
    
    <!-- Flash Sale Section Styles -->
    <style>
        .flash-sale-section {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8787 100%);
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        /* Decorative shapes */
        .flash-sale-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .flash-sale-shape.shape-1 {
            width: 200px;
            height: 200px;
            top: -50px;
            left: -50px;
        }
        
        .flash-sale-shape.shape-2 {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 5%;
            transform: translateY(-50%);
        }
        
        .flash-sale-shape.shape-3 {
            width: 100px;
            height: 100px;
            bottom: -30px;
            left: 20%;
        }
        
        .flash-sale-shape.shape-4 {
            width: 120px;
            height: 120px;
            top: 20px;
            right: 15%;
        }
        
        /* Header */
        .flash-sale-header {
            position: relative;
            z-index: 10;
        }
        
        .flash-icon-wrapper {
            width: 48px;
            height: 48px;
            background: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s ease-in-out infinite;
        }
        
        .flash-icon {
            width: 28px;
            height: 28px;
            color: #ff6b6b;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .flash-sale-title {
            color: #fff;
            font-weight: 700;
            font-size: 22px; /* Reduced from 28px */
            letter-spacing: 0.5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        /* Timer */
        .flash-sale-timer {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
        
        .timer-label {
            color: #fff;
            font-size: 13px; /* Reduced from 14px */
            font-weight: 500;
        }
        
        .timer-box {
            background: #000;
            color: #fff;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 16px; /* Reduced from 18px */
            font-weight: 700;
            min-width: 40px;
            text-align: center;
        }
        
        .timer-separator {
            color: #fff;
            font-size: 18px; /* Reduced from 20px */
            font-weight: 700;
        }
        
        .btn-see-all {
            background: #fff;
            color: #ff6b6b;
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }
        
        .btn-see-all:hover {
            background: #000;
            color: #fff;
            transform: translateX(5px);
        }
        
        /* Carousel */
        .flash-sale-carousel-wrapper {
            position: relative;
            z-index: 10;
        }
        
        .flash-sale-carousel {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px 0 20px;
            scrollbar-width: none;
        }
        
        .flash-sale-carousel::-webkit-scrollbar {
            display: none;
        }
        
        .flash-sale-item {
            flex: 0 0 auto;
            width: 220px;
        }
        
        .flash-sale-card {
            background: #fff;
            border-radius: 12px;
            padding: 12px;
            display: block;
            text-decoration: none;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .flash-sale-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .flash-sale-image {
            position: relative;
            width: 100%;
            height: 200px;
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 12px;
        }
        
        .flash-sale-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 10px;
        }
        
        .flash-sale-image .no-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
        }
        
        .flash-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #000;
            color: #fff;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .flash-sale-book-title {
            font-size: 13px; /* Reduced from 14px */
            color: #000;
            margin-bottom: 8px;
            min-height: 40px;
            font-weight: 500;
            line-height: 1.4;
        }
        
        .flash-sale-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }
        
        .price-flash {
            color: #ff6b6b;
            font-size: 16px; /* Reduced from 18px */
            font-weight: 700;
        }
        
        .price-discount {
            background: #ff6b6b;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .price-original {
            color: #999;
            text-decoration: line-through;
            font-size: 13px;
            margin-bottom: 12px;
        }
        
        .flash-sale-progress {
            margin-top: auto;
        }
        
        .flash-sale-progress .progress {
            height: 6px;
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 6px;
        }
        
        .flash-sale-progress .progress-bar {
            background: linear-gradient(90deg, #ff6b6b 0%, #ff8787 100%);
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }
        
        .progress-label {
            color: #666;
            font-size: 13px;
        }
        
        /* Carousel navigation */
        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        
        .carousel-nav:hover {
            background: #000;
            color: #fff;
        }
        
        .carousel-prev {
            left: -20px;
        }
        
        .carousel-next {
            right: -20px;
        }
        
        .carousel-nav svg {
            width: 20px;
            height: 20px;
        }
        
        /* Flash Sale Responsive */
        @media (max-width: 991px) {
            .flash-sale-title {
                font-size: 18px;
            }
            .timer-label {
                display: none;
            }
            .flash-sale-item {
                width: 200px;
            }
        }
        
        @media (max-width: 768px) {
            .flash-sale-section {
                padding: 1rem 0 !important;
            }
            .flash-sale-title {
                font-size: 16px;
            }
            .flash-icon-wrapper {
                width: 36px;
                height: 36px;
            }
            .flash-icon {
                width: 20px;
                height: 20px;
            }
            .timer-box {
                padding: 4px 6px;
                font-size: 14px;
                min-width: 30px;
            }
            .timer-separator {
                font-size: 14px;
            }
            .flash-sale-item {
                width: 160px;
            }
            .flash-sale-image {
                height: 160px;
            }
            .flash-sale-book-title {
                font-size: 12px;
                min-height: 34px;
            }
            .price-flash {
                font-size: 14px;
            }
            .price-discount {
                font-size: 11px;
            }
            .carousel-nav {
                display: none;
            }
            .flash-sale-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }
            .btn-see-all {
                padding: 6px 14px;
                font-size: 12px;
            }
        }
        
        @media (max-width: 575px) {
            .flash-sale-title {
                font-size: 14px;
            }
            .flash-icon-wrapper {
                width: 32px;
                height: 32px;
            }
            .flash-icon {
                width: 18px;
                height: 18px;
            }
            .timer-box {
                padding: 3px 5px;
                font-size: 13px;
                min-width: 26px;
            }
            .flash-sale-item {
                width: 140px;
            }
            .flash-sale-image {
                height: 140px;
            }
            .flash-sale-book-title {
                font-size: 11px;
                min-height: 30px;
            }
            .price-flash {
                font-size: 13px;
            }
            .price-original {
                font-size: 11px;
            }
            .flash-sale-card {
                padding: 8px;
            }
            .flash-badge {
                font-size: 10px;
                padding: 2px 6px;
            }
        }
    </style>
</head>
<body>
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
            padding: 0 24px;
            height: 60px;
            position: relative;
        }
        /* Left: Logo */
        .modern-nav .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-right: 40px;
        }
        .modern-nav .nav-brand .brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modern-nav .nav-brand .brand-icon svg {
            width: 18px;
            height: 18px;
            color: #fff;
        }
        .modern-nav .nav-brand .brand-text {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }
        /* Nav Links */
        .modern-nav .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
            margin: 0;
            padding: 0;
            flex: 1;
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
        .modern-nav .nav-links a:hover,
        .modern-nav .nav-links a.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }
        .modern-nav .nav-links a.active {
            border-bottom: 2px solid #a855f7;
        }
        /* Search Form */
        .modern-nav .nav-search {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 0 12px;
            margin-right: 16px;
            transition: all 0.22s ease;
        }
        .modern-nav .nav-search:focus-within {
            background: rgba(255,255,255,0.12);
            border-color: rgba(168,85,247,0.5);
        }
        .modern-nav .nav-search input {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 13px;
            padding: 8px 10px;
            width: 180px;
            outline: none;
        }
        .modern-nav .nav-search input::placeholder {
            color: rgba(255,255,255,0.5);
        }
        .modern-nav .nav-search button {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.6);
            cursor: pointer;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modern-nav .nav-search button:hover {
            color: #fff;
        }
        .modern-nav .nav-search button svg {
            width: 18px;
            height: 18px;
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
            position: relative;
        }
        .modern-nav .nav-icon-btn:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .modern-nav .nav-icon-btn svg {
            width: 20px;
            height: 20px;
        }
        .modern-nav .cart-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: linear-gradient(135deg, #ef4444, #f97316);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
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
            margin-top: 8px;
        }
        .modern-nav .dropdown-menu .dropdown-item {
            color: rgba(255,255,255,0.8);
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modern-nav .dropdown-menu .dropdown-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .modern-nav .dropdown-menu .dropdown-item svg {
            width: 16px;
            height: 16px;
            opacity: 0.7;
        }
        .modern-nav .dropdown-menu .dropdown-divider {
            border-color: rgba(255,255,255,0.08);
            margin: 6px 0;
        }
        /* Auth buttons for guest */
        .modern-nav .auth-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.22s ease;
        }
        .modern-nav .auth-btn.login {
            color: rgba(255,255,255,0.85);
            background: transparent;
        }
        .modern-nav .auth-btn.login:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }
        .modern-nav .auth-btn.register {
            color: #fff;
            background: linear-gradient(135deg, #7c3aed, #a855f7);
        }
        .modern-nav .auth-btn.register:hover {
            opacity: 0.9;
            transform: translateY(-1px);
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
            z-index: 1040;
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
        .modern-nav .mobile-search {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 0 12px;
            margin-bottom: 8px;
        }
        .modern-nav .mobile-search input {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 14px;
            padding: 12px 10px;
            flex: 1;
            outline: none;
        }
        .modern-nav .mobile-search input::placeholder {
            color: rgba(255,255,255,0.5);
        }
        .modern-nav .mobile-search button {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.6);
            cursor: pointer;
            padding: 8px;
        }
        .modern-nav .mobile-search button svg {
            width: 18px;
            height: 18px;
        }
        /* Responsive */
        @media (max-width: 991px) {
            .modern-nav .nav-links,
            .modern-nav .nav-search {
                display: none;
            }
            .modern-nav .mobile-toggle {
                display: flex;
            }
            .modern-nav .nav-container {
                justify-content: space-between;
            }
        }
        @media (min-width: 992px) {
            .modern-nav .mobile-menu {
                display: none !important;
            }
        }
    </style>

    <nav class="modern-nav">
        <div class="nav-container">
            <!-- Logo -->
            <a href="<?php echo e(route('home')); ?>" class="nav-brand">
                <div class="brand-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.708V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z"/>
                    </svg>
                </div>
                <span class="brand-text">BookStore</span>
            </a>

            <!-- Nav Links (Desktop) -->
            <ul class="nav-links">
                <li><a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Trang chủ</a></li>
                <li><a href="<?php echo e(route('books.index')); ?>" class="<?php echo e(request()->routeIs('books.*') ? 'active' : ''); ?>">Sách</a></li>
                <li><a href="<?php echo e(route('about')); ?>" class="<?php echo e(request()->routeIs('about') ? 'active' : ''); ?>">Giới thiệu</a></li>
                <li><a href="<?php echo e(route('contact')); ?>" class="<?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>">Liên hệ</a></li>
            </ul>

            <!-- Search Form (Desktop) -->
            <form class="nav-search" method="GET" action="<?php echo e(route('books.index')); ?>">
                <input type="search" name="search" placeholder="Tìm kiếm sách..." value="<?php echo e(request('search')); ?>">
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
            </form>

            <!-- Right Actions -->
            <div class="nav-actions">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="auth-btn login">Đăng nhập</a>
                    <a href="<?php echo e(route('register')); ?>" class="auth-btn register">Đăng ký</a>
                <?php else: ?>
                    <!-- Cart -->
                    <a href="<?php echo e(route('cart.index')); ?>" class="nav-icon-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121 0 2.09-.773 2.345-1.867l1.807-7.748H5.25M6.75 21a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        <span id="cartCount" class="cart-badge">0</span>
                    </a>

                    <!-- User Menu -->
                    <div class="user-dropdown dropdown">
                        <a href="#" class="user-btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></div>
                            <span><?php echo e(Auth::user()->name); ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('profile.index')); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    Thông tin cá nhân
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                    Đơn hàng của tôi
                                </a>
                            </li>
                            <?php if(Auth::user()->isAdmin() || (method_exists(Auth::user(), 'isStaff') && Auth::user()->isStaff())): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Quản trị
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    Đăng xuất
                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Mobile Toggle -->
                <button class="mobile-toggle" onclick="toggleMobileMenu()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu" id="mobileMenu">
                <form class="mobile-search" method="GET" action="<?php echo e(route('books.index')); ?>">
                    <input type="search" name="search" placeholder="Tìm kiếm sách..." value="<?php echo e(request('search')); ?>">
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </form>
                <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                <a href="<?php echo e(route('books.index')); ?>">Sách</a>
                <a href="<?php echo e(route('about')); ?>">Giới thiệu</a>
                <a href="<?php echo e(route('contact')); ?>">Liên hệ</a>
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>">Đăng nhập</a>
                    <a href="<?php echo e(route('register')); ?>">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('show');
        }
    </script>

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
    <main class="py-0">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>BookStore</h5>
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
                    <p>&copy; <?php echo e(date('Y')); ?> BookStore. All rights reserved.</p>
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

    <!-- AI Chatbot Widget -->
    <style>
        /* Chatbot Container */
        .chatbot-widget {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            font-family: 'Inter', sans-serif;
        }

        /* Chat Toggle Button */
        .chatbot-toggle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(124, 58, 237, 0.4);
            transition: all 0.3s ease;
            position: relative;
        }

        .chatbot-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(124, 58, 237, 0.5);
        }

        .chatbot-toggle svg {
            width: 28px;
            height: 28px;
            color: #fff;
        }

        .chatbot-toggle .close-icon {
            display: none;
        }

        .chatbot-widget.active .chatbot-toggle .chat-icon {
            display: none;
        }

        .chatbot-widget.active .chatbot-toggle .close-icon {
            display: block;
        }

        /* Notification Badge */
        .chatbot-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 20px;
            height: 20px;
            background: #ef4444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .chatbot-widget.active .chatbot-badge {
            display: none;
        }

        /* Chat Window */
        .chatbot-window {
            position: absolute;
            bottom: 75px;
            right: 0;
            width: 380px;
            height: 520px;
            background: #0f0f1a;
            border-radius: 20px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.4);
            display: none;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .chatbot-widget.active .chatbot-window {
            display: flex;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Chat Header */
        .chatbot-header {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chatbot-avatar {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chatbot-avatar svg {
            width: 24px;
            height: 24px;
            color: #fff;
        }

        .chatbot-info h4 {
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            margin: 0;
        }

        .chatbot-info p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            margin: 2px 0 0;
        }

        .chatbot-status {
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
            animation: blink 2s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Chat Messages */
        .chatbot-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            background: #0f0f1a;
        }

        .chatbot-messages::-webkit-scrollbar {
            width: 4px;
        }

        .chatbot-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .chatbot-messages::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .chat-message {
            display: flex;
            gap: 10px;
            max-width: 85%;
        }

        .chat-message.user {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .chat-message .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .chat-message.bot .avatar {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
        }

        .chat-message.user .avatar {
            background: #374151;
        }

        .chat-message .avatar svg {
            width: 16px;
            height: 16px;
            color: #fff;
        }

        .chat-message .content {
            padding: 12px 16px;
            border-radius: 16px;
            font-size: 13px;
            line-height: 1.5;
        }

        .chat-message.bot .content {
            background: #1a1a2e;
            color: rgba(255, 255, 255, 0.9);
            border-bottom-left-radius: 4px;
        }

        .chat-message.user .content {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: flex;
            gap: 4px;
            padding: 12px 16px;
            background: #1a1a2e;
            border-radius: 16px;
            width: fit-content;
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            animation: typing 1.4s infinite ease-in-out;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 100% { transform: translateY(0); opacity: 0.4; }
            50% { transform: translateY(-4px); opacity: 1; }
        }

        /* Quick Actions */
        .chatbot-quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 0 20px 16px;
            background: #0f0f1a;
        }

        .quick-action-btn {
            background: rgba(124, 58, 237, 0.15);
            border: 1px solid rgba(124, 58, 237, 0.3);
            color: #a855f7;
            font-size: 12px;
            padding: 8px 14px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-action-btn:hover {
            background: rgba(124, 58, 237, 0.25);
            border-color: #a855f7;
        }

        /* Chat Input */
        .chatbot-input {
            padding: 16px 20px;
            background: #1a1a2e;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .chatbot-input input {
            flex: 1;
            background: #0f0f1a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            color: #fff;
            font-size: 13px;
            outline: none;
            transition: all 0.2s ease;
        }

        .chatbot-input input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .chatbot-input input:focus {
            border-color: rgba(124, 58, 237, 0.5);
        }

        .chatbot-input button {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .chatbot-input button:hover {
            transform: scale(1.05);
        }

        .chatbot-input button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .chatbot-input button svg {
            width: 20px;
            height: 20px;
            color: #fff;
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .chatbot-widget {
                bottom: 16px;
                right: 16px;
            }

            .chatbot-window {
                width: calc(100vw - 32px);
                height: calc(100vh - 140px);
                max-height: 500px;
                right: 0;
            }

            .chatbot-toggle {
                width: 54px;
                height: 54px;
            }
        }
    </style>

    <!-- Chatbot HTML -->
    <div class="chatbot-widget" id="chatbotWidget">
        <!-- Toggle Button -->
        <button class="chatbot-toggle" onclick="toggleChatbot()">
            <svg class="chat-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
            </svg>
            <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="chatbot-badge">1</span>
        </button>

        <!-- Chat Window -->
        <div class="chatbot-window">
            <!-- Header -->
            <div class="chatbot-header">
                <div class="chatbot-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                    </svg>
                </div>
                <div class="chatbot-info">
                    <h4>BookStore AI</h4>
                    <p><span class="chatbot-status"></span>Trợ lý sách thông minh</p>
                </div>
            </div>

            <!-- Messages -->
            <div class="chatbot-messages" id="chatMessages">
                <div class="chat-message bot">
                    <div class="avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                        </svg>
                    </div>
                    <div class="content">
                        Xin chào! 👋 Tôi là trợ lý AI của BookStore. Tôi có thể giúp bạn tìm sách, gợi ý sách hay, hoặc trả lời các câu hỏi về đơn hàng. Bạn cần hỗ trợ gì?
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="chatbot-quick-actions">
                <button class="quick-action-btn" onclick="sendQuickMessage('Gợi ý sách hay')">📚 Sách hay</button>
                <button class="quick-action-btn" onclick="sendQuickMessage('Sách bán chạy')">🔥 Bán chạy</button>
                <button class="quick-action-btn" onclick="sendQuickMessage('Cách đặt hàng')">🛒 Đặt hàng</button>
                <button class="quick-action-btn" onclick="sendQuickMessage('Liên hệ hỗ trợ')">💬 Hỗ trợ</button>
            </div>

            <!-- Input -->
            <div class="chatbot-input">
                <input type="text" id="chatInput" placeholder="Nhập tin nhắn..." onkeypress="handleKeyPress(event)">
                <button onclick="sendMessage()" id="sendBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Chatbot Script -->
    <script>
        const GEMINI_API_KEY = 'AIzaSyDxRnAyk1RJT4Kt29jM10Jw67zUYgyTUxM';
        const GEMINI_API_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
        
        let chatHistory = [];
        let isProcessing = false;

        const SYSTEM_PROMPT = `Bạn là trợ lý AI thông minh của BookStore - một cửa hàng sách trực tuyến tại Việt Nam.

Nhiệm vụ của bạn:
- Giúp khách hàng tìm kiếm và gợi ý sách phù hợp
- Trả lời câu hỏi về sách, tác giả, thể loại
- Hướng dẫn cách đặt hàng, thanh toán, vận chuyển
- Giải đáp các thắc mắc về chính sách đổi trả, bảo hành
- Gợi ý sách theo sở thích, độ tuổi, mục đích đọc

Thông tin cửa hàng:
- Tên: BookStore
- Địa chỉ: Tân Bình, TP.HCM
- Điện thoại: 0343935487
- Email: hoquy902@gmail.com
- Miễn phí vận chuyển cho đơn từ 300.000đ
- Đổi trả trong 7 ngày nếu sách lỗi

Cách đặt hàng:
1. Chọn sách muốn mua và thêm vào giỏ hàng
2. Vào giỏ hàng, kiểm tra và nhấn "Thanh toán"
3. Điền thông tin giao hàng
4. Chọn phương thức thanh toán (COD hoặc chuyển khoản)
5. Xác nhận đơn hàng

Hãy trả lời ngắn gọn, thân thiện, bằng tiếng Việt. Sử dụng emoji phù hợp.`;

        function toggleChatbot() {
            const widget = document.getElementById('chatbotWidget');
            widget.classList.toggle('active');
            
            if (widget.classList.contains('active')) {
                document.getElementById('chatInput').focus();
            }
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function sendQuickMessage(message) {
            document.getElementById('chatInput').value = message;
            sendMessage();
        }

        async function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            
            if (!message || isProcessing) return;
            
            isProcessing = true;
            input.value = '';
            document.getElementById('sendBtn').disabled = true;

            // Add user message to chat
            addMessage(message, 'user');
            
            // Add to history
            chatHistory.push({ role: 'user', parts: [{ text: message }] });

            // Show typing indicator
            showTypingIndicator();

            try {
                const response = await callGeminiAPI(message);
                removeTypingIndicator();
                addMessage(response, 'bot');
                chatHistory.push({ role: 'model', parts: [{ text: response }] });
            } catch (error) {
                removeTypingIndicator();
                addMessage('Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau! 😔', 'bot');
                console.error('Chatbot error:', error);
            }

            isProcessing = false;
            document.getElementById('sendBtn').disabled = false;
        }

        async function callGeminiAPI(userMessage) {
            // Build contents array with system instruction embedded in first user message
            const contents = [];
            
            // Add history (last 6 messages for context)
            const recentHistory = chatHistory.slice(-6);
            recentHistory.forEach(msg => {
                contents.push({
                    role: msg.role,
                    parts: msg.parts
                });
            });

            // Add current message with system prompt if first message
            if (contents.length === 0) {
                contents.push({
                    role: 'user',
                    parts: [{ text: SYSTEM_PROMPT + '\n\nKhách hàng: ' + userMessage }]
                });
            } else {
                contents.push({
                    role: 'user',
                    parts: [{ text: userMessage }]
                });
            }

            try {
                const response = await fetch(`${GEMINI_API_URL}?key=${GEMINI_API_KEY}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        contents: contents,
                        generationConfig: {
                            temperature: 0.8,
                            topK: 40,
                            topP: 0.95,
                            maxOutputTokens: 800,
                        }
                    })
                });

                const data = await response.json();
                console.log('Gemini response:', data);

                if (!response.ok) {
                    console.error('API Error:', data);
                    throw new Error(data.error?.message || 'API request failed');
                }
                
                if (data.candidates && data.candidates[0] && data.candidates[0].content) {
                    return data.candidates[0].content.parts[0].text;
                }
                
                if (data.error) {
                    throw new Error(data.error.message);
                }
                
                throw new Error('Invalid response format');
            } catch (error) {
                console.error('Fetch error:', error);
                throw error;
            }
        }

        function addMessage(text, sender) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${sender}`;
            
            const avatarSvg = sender === 'bot' 
                ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                   </svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                   </svg>`;

            messageDiv.innerHTML = `
                <div class="avatar">${avatarSvg}</div>
                <div class="content">${formatMessage(text)}</div>
            `;
            
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function formatMessage(text) {
            // Convert markdown-like formatting to HTML
            return text
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/\n/g, '<br>');
        }

        function showTypingIndicator() {
            const messagesContainer = document.getElementById('chatMessages');
            const typingDiv = document.createElement('div');
            typingDiv.className = 'chat-message bot';
            typingDiv.id = 'typingIndicator';
            typingDiv.innerHTML = `
                <div class="avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                    </svg>
                </div>
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            `;
            messagesContainer.appendChild(typingDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function removeTypingIndicator() {
            const typing = document.getElementById('typingIndicator');
            if (typing) {
                typing.remove();
            }
        }
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>