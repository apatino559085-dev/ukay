@extends('layouts.admin')

@section('title', 'Manage Orders - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Orders</h1>
        <p style="color: #64748b; margin-top: 4px;">Monitor and update customer order fulfillment status.</p>
    </div>
</div>

<div class="table-card">
    @if($orders->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>
                            <div><strong>{{ $order->shipping_name }}</strong></div>
                            <div style="font-size: 12px; color: #64748b;">{{ $order->user->email ?? $order->shipping_phone }}</div>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                        <td>{{ strtoupper($order->payment_method ?? 'COD') }}</td>
                        <td>
                            <span class="badge badge-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">Manage Order</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="padding: 20px;">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state">
            <p>No customer orders placed yet.</p>
        </div>
    @endif
</div>
@endsection
