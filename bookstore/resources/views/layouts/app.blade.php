<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bookstore') }} - @yield('title', 'Home')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-orange: #FF6B35;
            --dark-orange: #E55A2B;
            --light-orange: #FF8559;
            --black: #1A1A1A;
            --white: #FFFFFF;
            --gray: #F5F5F5;
            --border-gray: #E5E5E5;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--black);
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }

        .med-container{width:95%;margin:auto;}
        
        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-orange);
            color: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background-color: var(--dark-orange);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }
        
        .btn-secondary {
            background-color: var(--white);
            color: #374151;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: 2px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
        }
        
        .bg-white{background:white;}

        .bg-grey{background:var(--gray);}

        .btn-secondary:hover {
            border-color: var(--primary-orange);
            color: var(--primary-orange);
        }
        
        #books-glide{background:white;}

        /* Orange Subheader */
        .top-bar {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
            padding: 0.5rem 0;
        }
        
        .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: var(--white);
        }
        
        .top-bar-left {
            display: flex;
            gap: 1.5rem;
        }
        
        /* Main Header */
        .header {
            background-color: var(--black);
            color: var(--white);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-link {
            display: inline-block;
            transition: opacity 0.3s;
        }
        
        .logo-link:hover {
            opacity: 0.8;
        }
        
        .main-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Navigation Link Styles with Underline */
        .nav-link {
            color: var(--white);
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            font-weight: 500;
            border-bottom: 2px solid transparent;
            background: transparent;
            cursor: pointer;
        }
        
        .nav-link:hover {
            border-bottom-color: var(--primary-orange);
        }
        
        .nav-link.active {
            border-bottom-color: var(--primary-orange);
        }
        
        /* Cart Badge */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #ef4444;
            color: white;
            font-size: 0.75rem;
            padding: 0.125rem 0.375rem;
            border-radius: 9999px;
            font-weight: 600;
        }
        
        /* Book Card Styles */
        .book-card {
            background-color: var(--white);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        
        .book-card img {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }
        
        .book-card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .book-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--black);
            text-decoration: none;
            display: block;
        }
        
        .book-title:hover {
            color: var(--primary-orange);
        }
        
        .book-author {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .book-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-orange);
            margin-top: auto;
        }
        
        /* Banner Styles */
        .banner-slider {
            position: relative;
            overflow: hidden;
        }
        
        .banner-slide {
            position: relative;
            height: 500px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .banner-content {
            background: rgba(0, 0, 0, 0.25);
            padding: 3rem;
            border-radius: 1rem;
            text-align: center;
            max-width: 800px;
        }
        
        .banner-title {
            font-size: 3rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 1rem;
        }
        
        .banner-description {
            font-size: 1.25rem;
            color: var(--white);
            margin-bottom: 2rem;
        }
        
        /* Section Title */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .title-container {
            padding-left: 3rem;
        }

        .px-3rem{padding-top:3rem;padding-bottom:3rem;}

        .pt-3rem{padding-top:3rem;}

        .featured-books {
            margin-top: 2.5rem;
            margin-bottom: 3rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--primary-orange);
        }
        
        /* Text Block */
        .text-block {
            background-color: var(--gray);
            padding: 3rem;
            border-radius: 1rem;
        }
        
        /* Contact Form */
        .contact-form {
            background-color: var(--gray); 
            padding-left: 3rem;
            padding-right: 3rem;
            margin-top: 1.25rem;
        }
        
        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .form-grid-3 {
                grid-template-columns: 1fr;
            }
            
            .top-bar-content {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .top-bar-left {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border-gray);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-orange);
        }
        
        /* Glide Carousel Styles */
        .glide {
            position: relative;
        }
        
        .glide__track {
            overflow: hidden;
        }
        
        .glide__slides {
            display: flex;
            gap: 1.5rem;
        }
        
        .glide__slide {
            flex-shrink: 0;
        }
        
        .glide__arrows {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            pointer-events: none;
        }
        
        .glide__arrow {
            background-color: var(--primary-orange);
            color: var(--white);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            pointer-events: all;
            transition: all 0.3s ease;
            font-size: 1.5rem;
        }
        
        .glide__arrow:hover {
            background-color: var(--dark-orange);
            transform: scale(1.1);
        }
        
        /* User Profile Dropdown */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .user-profile:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .user-profile-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: var(--white);
            color: var(--black);
            border-radius: 0.5rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            z-index: 1001;
            margin-top: 0.5rem;
        }

        .user-profile.active .user-profile-dropdown {
            display: block;
        }

        .user-profile-dropdown a,
        .user-profile-dropdown button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            border: none;
            background: none;
            color: var(--black);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .user-profile-dropdown a:hover,
        .user-profile-dropdown button:hover {
            background-color: var(--gray);
        }

        .user-email {
            font-size: 0.85rem;
            color: #d1d5db;
            white-space: nowrap;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #D4EDDA;
            color: #155724;
            border: 1px solid #C3E6CB;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        
        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border: 2px solid var(--border-gray);
            border-radius: 0.5rem;
            text-decoration: none;
            color: var(--black);
            transition: all 0.3s ease;
        }
        
        .pagination a:hover {
            background-color: var(--primary-orange);
            color: var(--white);
            border-color: var(--primary-orange);
        }
        
        .pagination .active {
            background-color: var(--primary-orange);
            color: var(--white);
            border-color: var(--primary-orange);
        }
        
        /* Footer Styles */
        .footer {
            background-color: var(--black);
            color: white;
        }
        
        .footer-main {
            padding: 3rem 0;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
        }
        
        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
        
        .footer-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-orange);
        }
        
        .footer-text {
            color: #d1d5db;
            line-height: 1.6;
            font-size: 0.875rem;
        }
        
        .footer-link {
            color: #d1d5db;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .footer-link:hover {
            color: var(--primary-orange);
        }
        
        .footer-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        /* Orange Subfooter */
        .subfooter {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
            padding: 1rem 0;
        }
        
        .subfooter-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
        }
        
        .subfooter-links {
            display: flex;
            gap: 1.5rem;
        }
        
        .subfooter-link {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        .subfooter-link:hover {
            opacity: 0.7;
        }
        
        @media (max-width: 768px) {
            .subfooter-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .subfooter-links {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased">
    
    <!-- Orange Top Bar -->
    <div class="top-bar">
        <div class="med-container mx-auto px-4">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <span><a href="mailto:info@hardcover.com"><i class="bi bi-envelope-fill"></i> info@hardcover.com</a></span>
                    <span><i class="bi bi-telephone-fill"></i> +1 (555) 123-4567</span>
                </div>
                <div>
                    <span>Free shipping on orders over £50</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="header">
        <div class="med-container mx-auto px-4">
            <div class="header-content">
                <div>
                    <a href="{{ route('home') }}" class="logo-link">
                        <img width="60px" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Bookstore') }}">
                    </a>
                </div>
                
                <nav class="main-nav">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('shop') }}" class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
                    <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" style="position: relative;">
                        Cart
                        @php
                            // Safe cart count calculation
                            $cartCount = 0;
                            if (auth()->check()) {
                                // For logged-in users, count cart items from database
                                $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                            } else {
                                // For guests, count from session
                                $sessionCart = session()->get('cart', []);
                                if (is_array($sessionCart)) {
                                    $cartCount = array_sum(array_column($sessionCart, 'quantity'));
                                }
                            }
                        @endphp
                        @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
             
                    @auth
                        <div class="user-profile" onclick="this.classList.toggle('active')">
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                            <span class="user-email">{{ auth()->user()->email }}</span>
                            <div class="user-profile-dropdown">
                                <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                                    @csrf
                                    <button type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary" style="margin-left: 0.5rem;">Register</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-main">
            <div class="med-container mx-auto px-4">
                <div class="footer-grid">
                    
                    <!-- About -->
                    <div>
                        <h3 class="footer-title">Bookstore</h3>
                        <p class="footer-text">
                            Your destination for discovering great books. We offer a curated selection of titles across all genres.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="footer-title" style="font-size: 1rem;">Quick Links</h4>
                        <ul class="footer-list">
                            <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                            <li><a href="{{ route('shop') }}" class="footer-link">Shop</a></li>
                            <li><a href="{{ route('cart.index') }}" class="footer-link">Cart</a></li>
                        </ul>
                    </div>

                    <!-- Customer Service -->
                    <div>
                        <h4 class="footer-title" style="font-size: 1rem;">Customer Service</h4>
                        <ul class="footer-list">
                            <li><a href="#" class="footer-link">Contact Us</a></li>
                            <li><a href="#" class="footer-link">Shipping Info</a></li>
                            <li><a href="#" class="footer-link">Returns</a></li>
                            <li><a href="#" class="footer-link">FAQ</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="footer-title" style="font-size: 1rem;">Contact</h4>
                        <ul class="footer-list">
                            <li class="footer-text" style="margin-bottom: 0.5rem;">info@hardcover.com</li>
                            <li class="footer-text" style="margin-bottom: 0.5rem;">+1 (555) 123-4567</li>
                            <li class="footer-text">
                                123 Book Street<br>
                                Reading City, RC 12345
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orange Subfooter -->
        <div class="subfooter">
            <div class="med-container mx-auto px-4">
                <div class="subfooter-content">
                    <div>
                        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Bookstore') }}. All rights reserved.</p>
                    </div>
                    <div class="subfooter-links">
                        <a href="#" class="subfooter-link">Privacy Policy</a>
                        <a href="#" class="subfooter-link">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>