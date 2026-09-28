@extends('layouts.app')

@section('title', 'Order Confirmed - THRIFT FINDS')

@section('content')
<section class="section">
    <div class="container">
        <div class="success-page">
            <div class="success-icon">✓</div>
            <h1>Order Confirmed!</h1>
            <p class="order-number">Order Number: <strong>{{ $order->order_number }}</strong></p>

            {{-- Email & Delivery Call Notification Banner --}}
            <div style="max-width: 500px; margin: 0 auto 24px; text-align: left; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 16px 20px; border-radius: 6px;">
                <p style="margin: 0 0 8px; font-size: 13px; color: #166534;">
                    ✉️ <strong>Email Sent:</strong> Gi-send na ang confirmation ug resibo sa imong email: <strong>{{ $order->email }}</strong>.
                </p>
                <p style="margin: 0; font-size: 13px; color: #166534;">
                    📞 <strong>Delivery Rider Call:</strong> Sa adlaw nga maabot ang imong ukay package, <strong>manawag ang among courier rider sa imong phone: {{ $order->phone }}</strong>. Palihug bantayi ang imong cellphone.
                </p>
            </div>

            <div style="max-width: 500px; margin: 0 auto; text-align: left;">
                <div class="order-summary" style="background: var(--light); padding: 24px; border-radius: 6px;">
                    <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Order Details</h3>

                    @foreach($order->items as $item)
                        <div class="order-item">
                            <div class="order-item-details">
                                <p class="order-item-name">{{ $item->product->name ?? 'Ukay Item' }}</p>
                                <p class="order-item-meta">Size: {{ $item->size }} &bull; Qty: {{ $item->quantity }}</p>
                            </div>
                            <p>₱{{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    @endforeach

                    <div style="border-top: 1px solid var(--border); margin-top: 12px; padding-top: 12px;">
                        <div class="cart-summary-row">
                            <span>Shipping</span>
                            <span>₱{{ number_format($order->shipping_fee, 2) }}</span>
                        </div>
                        <div class="cart-summary-row total">
                            <span>Total</span>
                            <span>₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <div style="margin-top: 14px; font-size: 13px; color: var(--secondary); border-top: 1px dashed var(--border); padding-top: 12px;">
                        <p style="margin-bottom: 4px;">Recipient: <strong>{{ $order->full_name }}</strong></p>
                        <p style="margin-bottom: 4px;">Phone: <strong>{{ $order->phone }}</strong></p>
                        <p style="margin-bottom: 4px;">Address: {{ $order->shipping_address }}, {{ $order->city }}</p>
                        <p style="margin-bottom: 0;">Payment: <strong>{{ strtoupper($order->payment_method) }}</strong></p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('account.index') }}" class="btn btn-outline" style="margin-right: 8px;">View My Orders</a>
                <a href="{{ route('shop') }}" class="btn btn-primary">Browse More Thrift Finds</a>
            </div>
        </div>
    </div>
</section>
@endsection
