@extends('layouts.app')

@section('title', 'Checkout - ThreadLine')

@section('content')
<div class="page-header">
    <h1>Checkout</h1>
</div>

<section class="section">
    <div class="container">
        <form method="POST" action="{{ route('checkout.placeOrder') }}">
            @csrf

            <div class="checkout-grid">
                {{-- Shipping Information --}}
                <div>
                    <h2 style="font-family: var(--font-heading); font-size: 20px; margin-bottom: 24px;">Shipping Information</h2>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control"
                               value="{{ old('full_name', $user->name) }}" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Active Mobile Phone Number *</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                   placeholder="e.g. 09171234567"
                                   value="{{ old('phone', $user->phone) }}" required>
                            <small style="color: #1e40af; background: #eff6ff; padding: 4px 8px; border-radius: 4px; font-size: 11px; display: block; margin-top: 6px;">
                                📞 <strong>Delivery Rider Protocol:</strong> Manawag ang delivery rider niining numeroha sa pag-abot sa imong address.
                            </small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="shipping_address">Address</label>
                        <textarea name="shipping_address" id="shipping_address" class="form-control"
                                  required>{{ old('shipping_address', $user->address) }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" name="city" id="city" class="form-control"
                                   value="{{ old('city', $user->city) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" name="province" id="province" class="form-control"
                                   value="{{ old('province', $user->province) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control"
                               value="{{ old('postal_code', $user->postal_code) }}" required
                               style="max-width: 200px;">
                    </div>

                    {{-- Payment Method --}}
                    <h2 style="font-family: var(--font-heading); font-size: 20px; margin: 32px 0 16px;">Payment Method</h2>

                    <div class="payment-methods">
                        <label class="payment-option selected" onclick="selectPayment(this)">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <label>Cash on Delivery (COD)</label>
                        </label>
                        <label class="payment-option" onclick="selectPayment(this)">
                            <input type="radio" name="payment_method" value="gcash">
                            <label>GCash</label>
                        </label>
                        <label class="payment-option" onclick="selectPayment(this)">
                            <input type="radio" name="payment_method" value="bank_transfer">
                            <label>Bank Transfer</label>
                        </label>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div>
                    <div class="order-summary">
                        <h3 class="order-summary-title">Order Summary</h3>

                        @foreach($cart->items as $item)
                            <div class="order-item">
                                <div class="order-item-details">
                                    <p class="order-item-name">{{ $item->product->name }}</p>
                                    <p class="order-item-meta">Size: {{ $item->size }} &bull; Qty: {{ $item->quantity }}</p>
                                </div>
                                <p><strong>₱{{ number_format($item->subtotal, 2) }}</strong></p>
                            </div>
                        @endforeach

                        <div style="border-top: 1px solid var(--border); margin-top: 16px; padding-top: 16px;">
                            <div class="cart-summary-row">
                                <span>Subtotal</span>
                                <span>₱{{ number_format($cart->total, 2) }}</span>
                            </div>
                            <div class="cart-summary-row">
                                <span>Shipping Fee</span>
                                <span>₱{{ number_format($shipping, 2) }}</span>
                            </div>
                            <div class="cart-summary-row total">
                                <span>Total</span>
                                <span>₱{{ number_format($cart->total + $shipping, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3" style="width: 100%;">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function selectPayment(element) {
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        element.querySelector('input[type="radio"]').checked = true;
    }
</script>
@endsection
