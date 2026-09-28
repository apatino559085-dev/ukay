<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ThreadLine - Premium streetwear and clothing. Explore our latest collection of tees, hoodies, shorts, and accessories.">
    <title>@yield('title', 'ThreadLine - Premium Streetwear')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @yield('styles')
</head>
<body>
    {{-- ========== HEADER ========== --}}
    <header class="site-header">
        <div class="header-top">
            {{-- Mobile Menu Toggle --}}
            <button class="mobile-toggle" onclick="document.querySelector('.nav-menu').classList.toggle('active')">
                <i class="fas fa-bars"></i>
            </button>

            {{-- Navigation Menu --}}
            <nav>
                <ul class="nav-menu">
                    <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a></li>
                    <li><a href="{{ route('size-chart') }}" class="{{ request()->routeIs('size-chart') ? 'active' : '' }}">Size Chart</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a></li>
                </ul>
            </nav>

            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" class="brand-logo">ThreadLine</a>

            {{-- Nav Icons --}}
            <div class="nav-icons">
                {{-- Search --}}
                <a href="{{ route('shop') }}" class="nav-icon" title="Search">
                    <i class="fas fa-search"></i>
                </a>

                {{-- Account --}}
                @auth
                    <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('account.index') }}" class="nav-icon" title="My Account">
                        <i class="fas fa-user"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-icon" title="Login">
                        <i class="fas fa-user"></i>
                    </a>
                @endauth

                {{-- Cart --}}
                <a href="{{ route('login') }}" class="nav-icon"
                   @auth
                       href="{{ route('cart.index') }}"
                   @endauth
                   title="Cart">
                    <i class="fas fa-shopping-bag"></i>
                    @auth
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())
                                ->first()?->items()->sum('quantity') ?? 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    @endauth
                </a>
            </div>
        </div>
    </header>

    {{-- ========== FLASH MESSAGES ========== --}}
    <div class="container" style="margin-top: 10px;">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="validation-errors">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- ========== MAIN CONTENT ========== --}}
    <main>
        @yield('content')
    </main>

    {{-- ========== FOOTER ========== --}}
    <footer class="site-footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>ThreadLine</h4>
                <p style="color: #999; font-size: 13px; line-height: 1.8;">
                    Premium streetwear crafted for the modern individual. Quality fabrics, timeless designs.
                </p>
            </div>
            <div class="footer-col">
                <h4>Shop</h4>
                <ul>
                    <li><a href="{{ route('shop') }}">All Products</a></li>
                    <li><a href="{{ route('shop', ['category' => 1]) }}">T-Shirts</a></li>
                    <li><a href="{{ route('shop', ['category' => 4]) }}">Hoodies</a></li>
                    <li><a href="{{ route('shop', ['category' => 6]) }}">Accessories</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Help</h4>
                <ul>
                    <li><a href="{{ route('size-chart') }}">Size Chart</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Shipping Info</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Account</h4>
                <ul>
                    @auth
                        <li><a href="{{ route('account.index') }}">My Account</a></li>
                        <li><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} ThreadLine. All rights reserved.
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
