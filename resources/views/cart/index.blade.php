@extends('layouts.app')

@section('title', 'Your Thrift Bag - THRIFT FINDS')

@section('content')
<div class="page-header">
    <h1>Your Thrift Bag</h1>
    <p>Review your selected 1-of-1 pre-loved items before checkout</p>
</div>

<section class="section">
    <div class="container">
        @if($cart->items->count() > 0)
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Ukay Item</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->items as $item)
                        <tr>
                            <td>
                                <div class="cart-item-info">
                                    <div class="cart-item-image">
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}">
                                    </div>
                                    <div>
                                        <p style="font-size: 11px; text-transform: uppercase; font-weight: 600; color: #64748b; margin-bottom: 2px;">
                                            {{ $item->product->brand ?? 'Ukay Find' }}
                                        </p>
                                        <p class="cart-item-name">
                                            <a href="{{ route('product.show', $item->product) }}">{{ $item->product->name }}</a>
                                        </p>
                                        @if($item->product->is_sold)
                                            <span style="color: #ef4444; font-size: 11px; font-weight: 700;">SOLD OUT - Remove from cart</span>
                                        @else
                                            <span style="color: #22c55e; font-size: 11px; font-weight: 600;">1 of 1 Unique Item</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><strong>{{ $item->size }}</strong></td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>
                                <span style="font-weight: 600; font-size: 14px;">{{ $item->quantity }}</span>
                            </td>
                            <td><strong>₱{{ number_format($item->subtotal, 2) }}</strong></td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Cart Summary --}}
            <div class="cart-summary">
                <div class="cart-summary-row">
                    <span>Items Subtotal</span>
                    <span>₱{{ number_format($cart->total, 2) }}</span>
                </div>
                <div class="cart-summary-row">
                    <span>Shipping Fee</span>
                    <span>₱{{ number_format($shipping, 2) }}</span>
                </div>
                <div class="cart-summary-row total">
                    <span>Total Amount</span>
                    <span>₱{{ number_format($cart->total + $shipping, 2) }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary mt-3" style="width: 100%;">
                    Proceed to Checkout →
                </a>
                <a href="{{ route('shop') }}" class="btn btn-outline mt-2" style="width: 100%;">
                    Continue Shopping Ukay Finds
                </a>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-shopping-bag"></i></div>
                <h3>Your Thrift Bag is Empty</h3>
                <p>Looks like you haven't added any pre-loved items to your bag yet.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">Browse Thrift Finds</a>
            </div>
        @endif
    </div>
</section>
@endsection
