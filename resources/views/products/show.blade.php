@extends('layouts.app')

@section('title', $product->name . ' - ThreadLine')

@section('content')
<section class="section">
    <div class="container">
        <div class="product-detail">
            @php
                $galleryList = [];
                if ($product->image) {
                    $galleryList[] = $product->image;
                }
                foreach ($product->images as $gImg) {
                    $galleryList[] = $gImg->image;
                }
                $galleryList = array_values(array_unique($galleryList));
            @endphp

            {{-- Product Gallery --}}
            <div class="product-gallery">
                <div class="product-main-image" id="mainImage">
                    @if(count($galleryList) > 1)
                        <button type="button" class="gallery-nav-btn prev" onclick="navigateGallery(-1)" aria-label="Previous Image">&lsaquo;</button>
                        <button type="button" class="gallery-nav-btn next" onclick="navigateGallery(1)" aria-label="Next Image">&rsaquo;</button>
                    @endif
                    <img src="{{ $galleryList[0] ?? '' }}" alt="{{ $product->name }}" id="mainImg">
                </div>

                {{-- Thumbnails --}}
                @if(count($galleryList) > 1)
                    <div class="product-thumbnails">
                        @foreach($galleryList as $index => $imgUrl)
                            <div class="product-thumbnail {{ $index === 0 ? 'active' : '' }}" onclick="selectGalleryIndex({{ $index }})" data-index="{{ $index }}">
                                <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="product-info">
                <p class="product-card-category" style="margin-bottom: 8px;">{{ $product->category->name ?? '' }}</p>
                <h1 class="product-name">{{ $product->name }}</h1>
                <p class="product-price">{{ $product->formatted_price }}</p>

                <p class="product-description">{{ $product->description }}</p>

                @if($product->material)
                    <p class="product-material">
                        <strong>Material:</strong> {{ $product->material }}
                    </p>
                @endif

                <p style="font-size: 13px; color: var(--secondary); margin-bottom: 20px;">
                    <strong>Stock:</strong> {{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}
                </p>

                @auth
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        {{-- Size Selection --}}
                        @if($product->sizes->count() > 0)
                            <div class="size-selector">
                                <p class="size-label">Select Size</p>
                                <div class="size-options">
                                    @foreach($product->sizes as $index => $size)
                                        <label class="size-option {{ $index === 0 ? 'selected' : '' }}"
                                               onclick="selectSize(this)">
                                            <input type="radio" name="size" value="{{ $size->name }}"
                                                   {{ $index === 0 ? 'checked' : '' }}>
                                            {{ $size->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="size" value="One Size">
                        @endif

                        {{-- Quantity --}}
                        <div class="quantity-selector">
                            <p class="quantity-label">Quantity</p>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">−</button>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                       class="quantity-input" id="quantityInput" readonly>
                                <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
                            </div>
                        </div>

                        {{-- Add to Cart --}}
                        <button type="submit" class="btn btn-primary add-to-cart-btn"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary add-to-cart-btn">Login to Purchase</a>
                @endauth

                {{-- Size Chart --}}
                @if($product->sizes->count() > 0)
                    <div class="mt-4" style="border-top: 1px solid var(--border); padding-top: 24px;">
                        <h3 style="font-size: 14px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 16px;">Size Chart</h3>
                        <table class="size-chart-table">
                            <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Width</th>
                                    <th>Length</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->sizes as $size)
                                    <tr>
                                        <td><strong>{{ $size->name }}</strong></td>
                                        <td>{{ $size->width ?? '-' }}</td>
                                        <td>{{ $size->length ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
            <div class="mt-4" style="border-top: 1px solid var(--border); padding-top: 60px;">
                <div class="section-header">
                    <p class="section-subtitle">You may also like</p>
                    <h2 class="section-title">Related Products</h2>
                </div>
                <div class="product-grid">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('product.show', $related) }}" class="product-card">
                            <div class="product-card-image">
                                @if($related->image)
                                    <img src="{{ asset($related->image) }}" alt="{{ $related->name }}">
                                @else
                                    <div class="product-placeholder">
                                        <i class="fas fa-tshirt"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="product-card-info">
                                <h3 class="product-card-name">{{ $related->name }}</h3>
                                <p class="product-card-price">{{ $related->formatted_price }}</p>
                                <p class="product-card-category">{{ $related->category->name ?? '' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Size selection
    function selectSize(element) {
        document.querySelectorAll('.size-option').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        element.querySelector('input').checked = true;
    }

    // Quantity control
    function changeQuantity(delta) {
        const input = document.getElementById('quantityInput');
        let value = parseInt(input.value) + delta;
        const max = parseInt(input.max);
        if (value < 1) value = 1;
        if (value > max) value = max;
        input.value = value;
    }

    // Image gallery swipe & navigation
    const galleryImages = @json($galleryList);
    let currentGalleryIndex = 0;

    function selectGalleryIndex(index) {
        if (!galleryImages || galleryImages.length === 0) return;
        currentGalleryIndex = (index + galleryImages.length) % galleryImages.length;
        const mainImg = document.getElementById('mainImg');
        if (mainImg) {
            mainImg.style.opacity = '0.4';
            setTimeout(() => {
                mainImg.src = galleryImages[currentGalleryIndex];
                mainImg.style.opacity = '1';
            }, 80);
        }
        document.querySelectorAll('.product-thumbnail').forEach((el, i) => {
            el.classList.toggle('active', i === currentGalleryIndex);
        });
    }

    function navigateGallery(direction) {
        selectGalleryIndex(currentGalleryIndex + direction);
    }

    // Touch Swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    const mainImgContainer = document.getElementById('mainImage');

    if (mainImgContainer) {
        mainImgContainer.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        mainImgContainer.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            const threshold = 40;
            if (touchEndX < touchStartX - threshold) {
                navigateGallery(1); // swipe left
            } else if (touchEndX > touchStartX + threshold) {
                navigateGallery(-1); // swipe right
            }
        }, { passive: true });
    }
</script>
@endsection
