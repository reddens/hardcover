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
        }
        
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
            background-color: var(--black);
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
        
        .btn-secondary:hover {
            background-color: #2A2A2A;
            transform: translateY(-2px);
        }
        
        .header {
            background-color: var(--black);
            color: var(--white);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .nav-link {
            color: var(--white);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .nav-link:hover {
            background-color: var(--primary-orange);
        }
        
        .nav-link.active {
            background-color: var(--primary-orange);
        }
        
        .footer {
            background-color: var(--black);
            color: var(--white);
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }
        
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
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .title-container{padding-left:3rem;}

        .featured-books{margin-top:2.5rem;margin-bottom:3rem;}
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--primary-orange);
        }
        
        .text-block {
            background-color: var(--gray);
            padding: 3rem;
            border-radius: 1rem;
            margin-bottom: 3rem;
        }
        
        .contact-form {
            background-color: var(--white);
            padding-left: 3rem;
            padding-right: 3rem;
            border-radius: 1rem;
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
    </style>
    
    @stack('styles')
</head>
<body class="antialiased">
    <!-- Header -->
    <header class="header">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold">
                    <a href="{{ route('home') }}" class="text-white hover:text-orange-500 transition-colors" style="text-decoration: none;">
                        📚 {{ config('app.name', 'Bookstore') }}
                    </a>
                </div>
                
                <nav class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('shop') }}" class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="nav-link">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary ml-2">Register</a>
                    @endauth
                </nav>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4">
                <nav class="flex flex-col space-y-2">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('shop') }}" class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link w-full text-left">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                        <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
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
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">About Us</h3>
                    <p class="text-gray-400">Your premier destination for quality books. We offer a wide selection of titles across all genres.</p>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-orange-500 transition-colors">Home</a></li>
                        <li><a href="{{ route('shop') }}" class="text-gray-400 hover:text-orange-500 transition-colors">Shop</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-orange-500 transition-colors">Dashboard</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact Info</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>📧 info@bookstore.com</li>
                        <li>📞 +1 (555) 123-4567</li>
                        <li>📍 123 Book Street, Reading City</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Bookstore') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
    
    @stack('scripts')
</body>
</html>