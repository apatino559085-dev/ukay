@extends('layouts.admin')

@section('title', 'Customer Profile - ' . $customer->name . ' - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Customer Profile</h1>
        <p style="color: #64748b; margin-top: 4px;">Details for customer account: {{ $customer->name }}</p>
    </div>
    <div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline">← Back to Customers</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
    {{-- Left: Profile Card --}}
    <div>
        <div class="table-card" style="padding: 24px;">
            <h3 style="font-size: 18px; margin-bottom: 16px;">Account Info</h3>
            <p><strong>Name:</strong> {{ $customer->name }}</p>
            <p style="margin-top: 8px;"><strong>Email:</strong> {{ $customer->email }}</p>
            <p style="margin-top: 8px;"><strong>Phone:</strong> {{ $customer->phone ?? 'Not provided' }}</p>
            <p style="margin-top: 8px;"><strong>Address:</strong> {{ $customer->address ?? 'Not provided' }}</p>
            <p style="margin-top: 8px;"><strong>Joined:</strong> {{ $customer->created_at->format('F d, Y') }}</p>
        </div>
    </div>

    {{-- Right: Order History --}}
    <div>
        <div class="table-card">
            <div class="table-card-header">
                <h3>Order History ({{ $customer->orders->count() }})</h3>
            </div>
            @if($customer->orders->count() > 0)
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->orders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">View Order</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <p>This customer hasn't placed any orders yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
