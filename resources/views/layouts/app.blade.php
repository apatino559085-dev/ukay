<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Thrift Finds - Online Ukay-Ukay Store. Unique pre-loved clothing, vintage streetwear, jackets, tees, and thrift items at affordable prices.">
    <title>@yield('title', 'Thrift Finds - Online Ukay-Ukay Store')</title>
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
                    <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}">Shop Ukay Finds</a></li>
                    <li><a href="{{ route('size-chart') }}" class="{{ request()->routeIs('size-chart') ? 'active' : '' }}">Size Guide</a></li>
                </ul>
            </nav>

            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" class="brand-logo">THRIFT FINDS</a>

            {{-- Nav Icons --}}
            <div class="nav-icons">
                {{-- Search --}}
                <a href="{{ route('shop') }}" class="nav-icon" title="Search Ukay Items">
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
                <a href="{{ route('cart.index') }}" class="nav-icon" title="Shopping Cart">
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
                <h4>THRIFT FINDS</h4>
                <p style="color: #999; font-size: 13px; line-height: 1.8;">
                    Your premier online ukay-ukay destination. Curated 1-of-1 pre-loved clothing, vintage streetwear, and affordable classic fits.
                </p>
            </div>
            <div class="footer-col">
                <h4>Thrift Categories</h4>
                <ul>
                    <li><a href="{{ route('shop') }}">All Ukay Finds</a></li>
                    <li><a href="{{ route('shop', ['category' => 1]) }}">T-Shirts</a></li>
                    <li><a href="{{ route('shop', ['category' => 3]) }}">Jackets</a></li>
                    <li><a href="{{ route('shop', ['category' => 6]) }}">Jeans</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Customer Help</h4>
                <ul>
                    <li><a href="{{ route('size-chart') }}">Size & Measurement Guide</a></li>
                    <li><a href="{{ route('about') }}">Our Ukay Mission</a></li>
                    <li><a href="{{ route('shop') }}">Thrift Guarantee</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Account & Orders</h4>
                <ul>
                    @auth
                        <li><a href="{{ route('account.index') }}">My Account</a></li>
                        <li><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login / Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} THRIFT FINDS - Online Ukay-Ukay Store. All rights reserved.
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
