<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - ThreadLine')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="admin-container">
        {{-- Admin Sidebar --}}
        <aside class="admin-sidebar">
            <div class="admin-brand">
                THREADLINE
                <span>Admin Management</span>
            </div>

            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="admin-nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    Products
                </a>
                <a href="{{ route('admin.categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    Categories
                </a>
                <a href="{{ route('admin.orders.index') }}" class="admin-nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    Orders
                </a>
                <a href="{{ route('admin.customers.index') }}" class="admin-nav-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    Customers
                </a>
                <a href="{{ route('admin.sizes.index') }}" class="admin-nav-item {{ request()->routeIs('admin.sizes.*') ? 'active' : '' }}">
                    Sizes
                </a>

                <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 15px 0;">

                <a href="{{ route('home') }}" class="admin-nav-item" target="_blank">
                    View Store Front
                </a>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="admin-nav-item" style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left;">
                        Logout
                    </button>
                </form>
            </nav>

            <div class="admin-user-info">
                <p>{{ Auth::user()->name }}</p>
                <span>Administrator</span>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="admin-main">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
