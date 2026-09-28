@extends('layouts.admin')

@section('title', 'Admin Dashboard - ThreadLine')

@section('content')
<div class="admin-header">
    <div>
        <h1>Dashboard</h1>
        <p style="color: #64748b; margin-top: 4px;">Welcome back, {{ Auth::user()->name }}. Here is an overview of your store.</p>
    </div>
    <div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add New Product</a>
    </div>
</div>

{{-- Stat Cards --}}
<div class="dashboard-cards">
    <div class="stat-card">
        <span class="stat-card-title">Total Sales</span>
        <span class="stat-card-value">${{ number_format($totalSales, 2) }}</span>
    </div>

    <div class="stat-card">
        <span class="stat-card-title">Total Orders</span>
        <span class="stat-card-value">{{ number_format($totalOrders) }}</span>
    </div>

    <div class="stat-card">
        <span class="stat-card-title">Total Products</span>
        <span class="stat-card-value">{{ number_format($totalProducts) }}</span>
    </div>

    <div class="stat-card">
        <span class="stat-card-title">Total Customers</span>
        <span class="stat-card-value">{{ number_format($totalCustomers) }}</span>
    </div>
</div>

{{-- Recent Orders Table --}}
<div class="table-card">
    <div class="table-card-header">
        <h3>Recent Orders</h3>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">View All Orders →</a>
    </div>

    @if($recentOrders->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->user->name ?? $order->shipping_name }}</td>
                        <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                        <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                        <td>
                            <span class="badge badge-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <p>No orders recorded yet.</p>
        </div>
    @endif
</div>
@endsection
