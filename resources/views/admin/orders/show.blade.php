@extends('layouts.admin')

@section('title', 'Order Details - ' . $order->order_number . ' - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Order {{ $order->order_number }}</h1>
        <p style="color: #64748b; margin-top: 4px;">Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
    </div>
    <div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">← Back to Orders</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    {{-- Left: Order items & Customer info --}}
    <div>
        <div class="table-card mb-4">
            <div class="table-card-header">
                <h3>Purchased Items</h3>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-center gap-2">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="table-img">
                                    @endif
                                    <div>
                                        <strong>{{ $item->product->name ?? 'Product Unavailable' }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-customer">{{ $item->size }}</span></td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td><strong>${{ number_format($item->subtotal, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 20px; border-top: 1px solid #e2e8f0; text-align: right;">
                <p style="font-size: 16px;">Total Amount: <strong style="font-size: 22px; color: #0f172a;">${{ number_format($order->total_amount, 2) }}</strong></p>
            </div>
        </div>

        <div class="table-card" style="padding: 24px;">
            <h3 style="font-size: 18px; margin-bottom: 16px;">Shipping Information</h3>
            <p><strong>Recipient:</strong> {{ $order->shipping_name }}</p>
            <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
            <p><strong>Address:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
            @if($order->notes)
                <p style="margin-top: 12px; font-style: italic; color: #64748b;"><strong>Notes:</strong> "{{ $order->notes }}"</p>
            @endif
        </div>
    </div>

    {{-- Right: Update status sidebar --}}
    <div>
        <div class="table-card" style="padding: 24px;">
            <h3 style="font-size: 18px; margin-bottom: 16px;">Order Status Management</h3>
            
            <div class="mb-3">
                <span class="badge badge-{{ $order->status }}" style="font-size: 14px; padding: 6px 14px;">
                    Current Status: {{ ucfirst($order->status) }}
                </span>
            </div>

            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group mb-3">
                    <label class="form-label">Update Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Save Status</button>
            </form>
        </div>

        <div class="table-card mt-3" style="padding: 24px;">
            <h3 style="font-size: 18px; margin-bottom: 12px;">Payment Summary</h3>
            <p><strong>Method:</strong> {{ strtoupper($order->payment_method ?? 'COD') }}</p>
            <p><strong>Payment Status:</strong> {{ $order->status == 'completed' ? 'Paid' : 'Pending Fulfillment' }}</p>
        </div>
    </div>
</div>
@endsection
