@extends('layouts.app')

@section('title', $product->name . ' - THRIFT FINDS')

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

            {{-- Thrift Item Details --}}
            <div class="product-info">
                <div class="d-flex justify-between align-center mb-2">
                    <span style="font-size: 13px; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 1px;">
                        {{ $product->category->name ?? 'Ukay Find' }}
                    </span>
                    @if($product->is_sold)
                        <span style="background: #ef4444; color: #ffffff; padding: 4px 12px; font-size: 12px; font-weight: 700; border-radius: 4px; letter-spacing: 1px;">
                            SOLD OUT
                        </span>
                    @else
                        <span style="background: #22c55e; color: #ffffff; padding: 4px 12px; font-size: 12px; font-weight: 700; border-radius: 4px; letter-spacing: 1px;">
                            AVAILABLE (1 OF 1)
                        </span>
                    @endif
                </div>

                <h1 class="product-name" style="margin-bottom: 8px;">{{ $product->name }}</h1>
                <p class="product-price" style="font-size: 26px; font-weight: 700; color: #111111; margin-bottom: 20px;">
                    {{ $product->formatted_price }}
                </p>

                {{-- Key Thrift Attributes Grid --}}
                <div style="background: #f8fafc; padding: 18px 20px; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 14px;">
                    <div><strong>Brand:</strong> {{ $product->brand ?? 'Unbranded / Vintage' }}</div>
                    <div><strong>Size:</strong> {{ $product->size_text ?? 'Free Size' }}</div>
                    <div><strong>Condition:</strong> {{ $product->condition ?? 'Good' }}</div>
                    <div><strong>Color:</strong> {{ $product->color ?? 'As Pictured' }}</div>
                </div>

                {{-- Measurements --}}
                @if($product->measurements)
                    <div style="margin-bottom: 24px;">
                        <h4 style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; color: #334155;">
                            Measurements:
                        </h4>
                        <p style="font-size: 14px; color: #475569; background: #ffffff; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 4px;">
                            {{ $product->measurements }}
                        </p>
                    </div>
                @endif

                {{-- Description --}}
                @if($product->description)
                    <div style="margin-bottom: 24px;">
                        <h4 style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; color: #334155;">
                            Item Description:
                        </h4>
                        <p class="product-description" style="color: #475569; font-size: 14px; line-height: 1.7;">
                            {{ $product->description }}
                        </p>
                    </div>
                @endif

                {{-- Add to Cart Form --}}
                @if(!$product->is_sold)
                    @auth
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="size" value="{{ $product->size_text ?? 'Standard' }}">

                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 15px; font-weight: 700; letter-spacing: 1px;">
                                ADD TO CART &bull; {{ $product->formatted_price }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary" style="display: block; text-align: center; width: 100%; padding: 16px; font-size: 14px; font-weight: 700; text-decoration: none; letter-spacing: 0.5px;">
                            LOGIN WITH GMAIL TO ADD TO CART &bull; {{ $product->formatted_price }}
                        </a>
                        <small style="color: #64748b; display: block; text-align: center; margin-top: 8px;">
                            Log in with your Gmail / Account first to secure this unique ukay item.
                        </small>
                    @endauth
                @else
                    <button type="button" class="btn" style="width: 100%; padding: 16px; font-size: 15px; font-weight: 700; background: #cbd5e1; color: #64748b; cursor: not-allowed;" disabled>
                        ITEM IS SOLD OUT
                    </button>
                @endif
            </div>
        </div>

        {{-- Related Thrift Items --}}
        @if($relatedProducts->count() > 0)
            <div style="margin-top: 60px;">
                <h3 style="font-family: var(--font-heading); font-size: 22px; margin-bottom: 24px;">More Thrift Finds</h3>
                <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
                    @foreach($relatedProducts as $relProduct)
                        <div class="product-card">
                            <a href="{{ route('product.show', $relProduct) }}">
                                <div class="product-card-image">
                                    <img src="{{ $relProduct->image }}" alt="{{ $relProduct->name }}">
                                </div>
                            </a>
                            <div class="product-card-info">
                                <h3 class="product-card-name">
                                    <a href="{{ route('product.show', $relProduct) }}">{{ $relProduct->name }}</a>
                                </h3>
                                <p class="product-card-price">{{ $relProduct->formatted_price }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
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
