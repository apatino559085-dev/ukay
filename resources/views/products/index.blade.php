@extends('layouts.app')

@section('title', 'Shop - ThreadLine')

@section('content')
<div class="page-header">
    <h1>Shop</h1>
    <p>Browse our collection</p>
</div>

<section class="section">
    <div class="container">
        {{-- Search Bar --}}
        <form action="{{ route('shop') }}" method="GET" class="search-bar">
            <input type="text" name="search" placeholder="Search products..."
                   value="{{ request('search') }}">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <button type="submit">Search</button>
        </form>

        {{-- Category Filter --}}
        <div class="category-filter">
            <a href="{{ route('shop') }}" class="{{ !request('category') ? 'active' : '' }}">All</a>
            @foreach($categories as $category)
                <a href="{{ route('shop', ['category' => $category->id, 'search' => request('search')]) }}"
                   class="{{ request('category') == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- Products Grid --}}
        @if($products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
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

            {{-- Pagination --}}
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-search"></i></div>
                <h3>No products found</h3>
                <p>Try adjusting your search or filter.</p>
                <a href="{{ route('shop') }}" class="btn btn-outline">Clear Filters</a>
            </div>
        @endif
    </div>
</section>
@endsection
