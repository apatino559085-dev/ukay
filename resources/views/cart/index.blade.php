@extends('layouts.app')

@section('title', 'Shopping Cart - ThreadLine')

@section('content')
<div class="page-header">
    <h1>Shopping Cart</h1>
</div>

<section class="section">
    <div class="container">
        @if($cart->items->count() > 0)
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Quantity</th>
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
                                        <p class="cart-item-name">{{ $item->product->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->size }}</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.update', $item) }}" style="display: flex; align-items: center;">
                                    @csrf
                                    @method('PATCH')
                                    <div class="quantity-control" style="transform: scale(0.85);">
                                        <button type="button" class="quantity-btn"
                                                onclick="this.parentElement.querySelector('input').value = Math.max(1, parseInt(this.parentElement.querySelector('input').value) - 1); this.closest('form').submit();">−</button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                               class="quantity-input" readonly>
                                        <button type="button" class="quantity-btn"
                                                onclick="this.parentElement.querySelector('input').value = parseInt(this.parentElement.querySelector('input').value) + 1; this.closest('form').submit();">+</button>
                                    </div>
                                </form>
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
                    <span>Subtotal</span>
                    <span>₱{{ number_format($cart->total, 2) }}</span>
                </div>
                <div class="cart-summary-row">
                    <span>Shipping</span>
                    <span>₱{{ number_format($shipping, 2) }}</span>
                </div>
                <div class="cart-summary-row total">
                    <span>Total</span>
                    <span>₱{{ number_format($cart->total + $shipping, 2) }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary mt-3" style="width: 100%;">
                    Proceed to Checkout
                </a>
                <a href="{{ route('shop') }}" class="btn btn-outline mt-2" style="width: 100%;">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-shopping-bag"></i></div>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any items yet.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        @endif
    </div>
</section>
@endsection
