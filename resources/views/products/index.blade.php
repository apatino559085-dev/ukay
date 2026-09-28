@extends('layouts.app')

@section('title', 'Shop Ukay Finds - THRIFT FINDS')

@section('content')
<div class="page-header">
    <h1>SHOP UKAY FINDS</h1>
    <p>Unique pre-loved clothing & authentic vintage pieces</p>
</div>

<section class="section">
    <div class="container">
        {{-- Search Bar --}}
        <form method="GET" action="{{ route('shop') }}" class="search-bar">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if(request('condition'))
                <input type="hidden" name="condition" value="{{ request('condition') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by item name, brand (e.g. Levi's, Adidas)...">
            <button type="submit">Search</button>
        </form>

        {{-- Category & Condition Filter --}}
        <div class="category-filter mb-4">
            <a href="{{ route('shop', array_merge(request()->except('category', 'page'))) }}" class="{{ !request('category') ? 'active' : '' }}">All Categories</a>
            @foreach($categories as $category)
                <a href="{{ route('shop', array_merge(request()->except('page'), ['category' => $category->id])) }}"
                   class="{{ request('category') == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- Condition Filter Pills --}}
        <div class="d-flex justify-between align-center mb-4" style="flex-wrap: wrap; gap: 15px; background: #f8fafc; padding: 14px 20px; border-radius: 6px; border: 1px solid #e2e8f0;">
            <div class="d-flex align-center gap-2">
                <span style="font-size: 13px; font-weight: 600; color: #475569;">Condition:</span>
                <a href="{{ route('shop', array_merge(request()->except('condition', 'page'))) }}"
                   style="font-size: 12px; padding: 4px 12px; border-radius: 12px; text-decoration: none; {{ !request('condition') ? 'background: #111; color: #fff;' : 'background: #fff; color: #333; border: 1px solid #ccc;' }}">
                    All
                </a>
                @foreach(['New / Like New', 'Excellent', 'Good', 'Fair'] as $cond)
                    <a href="{{ route('shop', array_merge(request()->except('page'), ['condition' => $cond])) }}"
                       style="font-size: 12px; padding: 4px 12px; border-radius: 12px; text-decoration: none; {{ request('condition') == $cond ? 'background: #111; color: #fff;' : 'background: #fff; color: #333; border: 1px solid #ccc;' }}">
                        {{ $cond }}
                    </a>
                @endforeach
            </div>

            <div style="font-size: 13px; color: #64748b;">
                Showing {{ $products->total() }} ukay item(s)
            </div>
        </div>

        {{-- Products Grid --}}
        @if($products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
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

            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-tshirt"></i>
                </div>
                <h3>No Ukay Finds Found</h3>
                <p>No thrift items matched your criteria. Try adjusting your search term or filters.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">Clear Filters</a>
            </div>
        @endif
    </div>
</section>
@endsection
