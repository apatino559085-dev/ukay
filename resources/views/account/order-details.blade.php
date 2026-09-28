@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' - ThreadLine')

@section('content')
<div class="page-header">
    <h1>Order Details</h1>
    <p>{{ $order->order_number }}</p>
</div>

<section class="section">
    <div class="container" style="max-width: 800px;">
        {{-- Order Info --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <p style="font-size: 13px; color: var(--secondary);">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
        </div>

        {{-- Order Items --}}
        <div class="admin-card">
            <h2>Order Items</h2>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td><strong>{{ $item->product->name ?? 'Product Deleted' }}</strong></td>
                            <td>{{ $item->size }}</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td><strong>₱{{ number_format($item->subtotal, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            {{-- Shipping Info --}}
            <div class="admin-card">
                <h2>Shipping Address</h2>
                <p style="line-height: 1.8; font-size: 13px;">
                    <strong>{{ $order->full_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}<br>
                    {{ $order->phone }}<br>
                    {{ $order->email }}
                </p>
            </div>

            {{-- Payment Summary --}}
            <div class="admin-card">
                <h2>Payment Summary</h2>
                <div class="cart-summary-row">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($order->total_amount - $order->shipping_fee, 2) }}</span>
                </div>
                <div class="cart-summary-row">
                    <span>Shipping Fee</span>
                    <span>₱{{ number_format($order->shipping_fee, 2) }}</span>
                </div>
                <div class="cart-summary-row total">
                    <span>Total</span>
                    <span>₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
                <p style="margin-top: 12px; font-size: 13px; color: var(--secondary);">
                    Payment Method: <strong>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</strong>
                </p>
            </div>
        </div>

        <a href="{{ route('account.index') }}" class="btn btn-outline mt-3">← Back to Account</a>
    </div>
</section>
@endsection
