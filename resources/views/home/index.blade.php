@extends('layouts.app')

@section('title', 'THRIFT FINDS - Online Ukay-Ukay Store')

@section('content')
{{-- ========== HERO SECTION ========== --}}
<section class="hero-section">
    <div class="hero-content">
        <p class="hero-subtitle">Curated Pre-Loved Apparel</p>
        <h1 class="hero-title">FIND YOUR NEXT<br>THRIFTED FIT</h1>
        <p class="hero-description">Unique 1-of-1 pre-loved pieces at affordable prices. Authentic vintage jackets, classic tees, denim, and streetwear finds.</p>
        <a href="{{ route('shop') }}" class="btn btn-primary">SHOP UKAY FINDS</a>
    </div>
</section>

{{-- ========== FEATURED PRODUCTS ========== --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <p class="section-subtitle">Freshly Added</p>
            <h2 class="section-title">NEW THRIFT FINDS</h2>
        </div>

        <div class="product-grid">
            @foreach($featuredProducts as $product)
                <div class="product-card" style="position: relative;">
                    <a href="{{ route('product.show', $product) }}">
                        <div class="product-card-image">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            @if($product->is_sold)
                                <div style="position: absolute; top: 12px; right: 12px; background: #ef4444; color: #ffffff; padding: 4px 10px; font-size: 11px; font-weight: 700; text-transform: uppercase; border-radius: 4px; letter-spacing: 1px;">
                                    SOLD OUT
                                </div>
                            @else
                                <div style="position: absolute; top: 12px; right: 12px; background: #22c55e; color: #ffffff; padding: 4px 10px; font-size: 11px; font-weight: 700; text-transform: uppercase; border-radius: 4px; letter-spacing: 1px;">
                                    AVAILABLE
                                </div>
                            @endif
                        </div>
                    </a>
                    <div class="product-card-info">
                        <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; margin-bottom: 2px;">
                            {{ $product->brand ?? $product->category->name ?? 'Ukay Find' }}
                        </p>
                        <h3 class="product-card-name">
                            <a href="{{ route('product.show', $product) }}">{{ $product->name }}</a>
                        </h3>
                        <div style="font-size: 12px; color: #555555; margin-bottom: 6px;">
                            @if($product->size_text) Size: <strong>{{ $product->size_text }}</strong> @endif
                            @if($product->condition) &bull; {{ $product->condition }} Condition @endif
                        </div>
                        <p class="product-card-price" style="font-weight: 700; font-size: 16px;">{{ $product->formatted_price }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('shop') }}" class="btn btn-outline">Explore All Thrift Finds →</a>
        </div>
    </div>
</section>

{{-- ========== CATEGORIES ========== --}}
<section class="section" style="background: var(--light);">
    <div class="container">
        <div class="section-header">
            <p class="section-subtitle">Browse By Item</p>
            <h2 class="section-title">Ukay Categories</h2>
        </div>

        <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
            @foreach($categories as $category)
                <a href="{{ route('shop', ['category' => $category->id]) }}" class="product-card" style="text-align: center; padding: 24px; background: #ffffff; border-radius: 6px; text-decoration: none;">
                    <h3 style="font-size: 16px; font-weight: 600; color: #111111; margin-bottom: 4px;">{{ $category->name }}</h3>
                    <p style="font-size: 12px; color: #666666;">{{ $category->description ?? 'Pre-loved items' }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== BRAND STORY ========== --}}
<section class="section">
    <div class="container" style="max-width: 800px; text-align: center;">
        <p class="section-subtitle">Sustainable Fashion</p>
        <h2 class="section-title" style="margin-bottom: 20px;">Why Shop Pre-Loved Ukay?</h2>
        <p style="color: var(--secondary); font-size: 15px; line-height: 1.8; margin-bottom: 24px;">
            Every piece at <strong>THRIFT FINDS</strong> is a unique, one-of-one item handpicked for quality and style. Giving pre-loved clothing a second life not only saves you money but also reduces environmental waste. Once an item is gone, it's gone for good!
        </p>
        <a href="{{ route('about') }}" class="btn btn-outline">Learn About Our Mission</a>
    </div>
</section>
@endsection
