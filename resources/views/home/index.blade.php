@extends('layouts.app')

@section('title', 'ThreadLine - Premium Streetwear')

@section('content')
{{-- ========== HERO SECTION ========== --}}
<section class="hero-section">
    <div class="hero-content">
        <p class="hero-subtitle">New Collection</p>
        <h1 class="hero-title">Explore The<br>Latest Drop</h1>
        <p class="hero-description">Premium streetwear essentials crafted with quality fabrics and timeless designs for the modern individual.</p>
        <a href="{{ route('shop') }}" class="btn btn-primary">Shop Now</a>
    </div>
</section>

{{-- ========== FEATURED PRODUCTS ========== --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <p class="section-subtitle">Our Collection</p>
            <h2 class="section-title">Featured Products</h2>
        </div>

        <div class="product-grid">
            @foreach($featuredProducts as $product)
                <a href="{{ route('product.show', $product) }}" class="product-card">
                    <div class="product-card-image">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-card-info">
                        <h3 class="product-card-name">{{ $product->name }}</h3>
                        <p class="product-card-price">{{ $product->formatted_price }}</p>
                        <p class="product-card-category">{{ $product->category->name ?? '' }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('shop') }}" class="btn btn-outline">View All Products</a>
        </div>
    </div>
</section>

{{-- ========== CATEGORIES ========== --}}
<section class="section" style="background: var(--light);">
    <div class="container">
        <div class="section-header">
            <p class="section-subtitle">Browse By</p>
            <h2 class="section-title">Categories</h2>
        </div>

        <div class="product-grid" style="grid-template-columns: repeat(3, 1fr);">
            @foreach($categories->take(6) as $category)
                <a href="{{ route('shop', ['category' => $category->id]) }}" class="product-card">
                    <div class="product-card-image" style="aspect-ratio: 4/3;">
                        <div class="product-placeholder" style="font-size: 24px; flex-direction: column; gap: 12px;">
                            @switch($category->name)
                                @case('T-Shirts')
                                    <i class="fas fa-tshirt"></i>
                                    @break
                                @case('Shorts')
                                    <i class="fas fa-person-running"></i>
                                    @break
                                @case('Pants')
                                    <i class="fas fa-vest-patches"></i>
                                    @break
                                @case('Hoodies')
                                    <i class="fas fa-shirt"></i>
                                    @break
                                @case('Hats')
                                    <i class="fas fa-hat-cowboy"></i>
                                    @break
                                @default
                                    <i class="fas fa-bag-shopping"></i>
                            @endswitch
                            <span style="font-size: 14px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase;">{{ $category->name }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== ABOUT SECTION ========== --}}
<section class="section about-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-image">
                <i class="fas fa-scissors"></i>
            </div>
            <div class="about-text">
                <p class="section-subtitle">Our Story</p>
                <h2>Crafted For The Modern Individual</h2>
                <p>ThreadLine was born from a passion for quality streetwear that doesn't compromise on comfort or style. Every piece in our collection is thoughtfully designed with premium fabrics and attention to detail.</p>
                <p>From graphic tees to essential hoodies, we create versatile pieces that seamlessly blend into your everyday wardrobe while making a statement.</p>
                <a href="{{ route('about') }}" class="btn btn-outline">Learn More</a>
            </div>
        </div>
    </div>
</section>
@endsection
