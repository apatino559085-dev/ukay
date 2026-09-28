@extends('layouts.admin')

@section('title', 'Order Details - ' . $order->order_number . ' - THRIFT FINDS Admin')

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
                <h3>Purchased Ukay Items</h3>
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
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="table-img">
                                    @endif
                                    <div>
                                        <strong>{{ $item->product->name ?? 'Ukay Find' }}</strong>
                                        <div style="font-size: 12px; color: #64748b;">Brand: {{ $item->product->brand ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-customer">{{ $item->size }}</span></td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td><strong>₱{{ number_format($item->subtotal, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 20px; border-top: 1px solid #e2e8f0; text-align: right;">
                <p style="font-size: 14px; color: #64748b; margin-bottom: 4px;">Shipping Fee: ₱{{ number_format($order->shipping_fee, 2) }}</p>
                <p style="font-size: 16px;">Total Amount: <strong style="font-size: 22px; color: #0f172a;">₱{{ number_format($order->total_amount, 2) }}</strong></p>
            </div>
        </div>

        {{-- Shipping & Contact Info --}}
        <div class="table-card" style="padding: 24px;">
            <h3 style="font-size: 18px; margin-bottom: 16px;">Customer & Delivery Contact</h3>
            <p style="margin-bottom: 10px;">
                <strong>Customer Name:</strong> {{ $order->full_name ?? $order->user->name ?? 'Guest' }}
            </p>
            <p style="margin-bottom: 10px;">
                <strong>Email Address:</strong> <a href="mailto:{{ $order->email }}">{{ $order->email }}</a>
            </p>
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; padding: 12px 16px; border-radius: 6px; margin: 12px 0;">
                <p style="margin: 0; font-size: 14px; color: #1e40af;">
                    📞 <strong>Delivery Phone Number:</strong>
                    <strong style="font-size: 16px; margin-left: 6px;">{{ $order->phone }}</strong>
                    <a href="tel:{{ $order->phone }}" class="btn btn-primary btn-sm" style="margin-left: 12px; padding: 4px 10px; font-size: 12px; text-decoration: none;">
                        Call Customer
                    </a>
                </p>
                <small style="color: #3b82f6; display: block; margin-top: 4px;">
                    Rider note: Please call this number upon arriving at the customer's delivery destination.
                </small>
            </div>
            <p style="margin-top: 12px;">
                <strong>Delivery Address:</strong> {{ $order->shipping_address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}
            </p>
        </div>
    </div>

    {{-- Right: Update status sidebar --}}
    <div>
        <div class="table-card" style="padding: 24px;">
            <h3 style="font-size: 18px; margin-bottom: 16px;">Order Status & Email Trigger</h3>
            
            <div class="mb-3">
                <span class="badge badge-{{ $order->status }}" style="font-size: 14px; padding: 6px 14px;">
                    Current: {{ ucfirst($order->status) }}
                </span>
            </div>

            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group mb-3">
                    <label class="form-label">Change Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Received)</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing (Approved)</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (On The Way / Rider Assigned)</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Delivered)</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <small style="color: #64748b; display: block; margin-top: 6px; font-size: 12px;">
                        ✉️ An email will automatically be sent to <strong>{{ $order->email }}</strong> notifying them when approved or ready to ship.
                    </small>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Update & Send Email
                </button>
            </form>
        </div>

        <div class="table-card mt-3" style="padding: 24px;">
            <h3 style="font-size: 18px; margin-bottom: 12px;">Payment Details</h3>
            <p><strong>Method:</strong> {{ strtoupper($order->payment_method ?? 'COD') }}</p>
            <p><strong>Payment Status:</strong> {{ $order->status == 'completed' ? 'Paid' : 'Pending Delivery Collection' }}</p>
        </div>
    </div>
</div>
@endsection
