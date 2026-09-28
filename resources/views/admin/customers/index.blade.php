@extends('layouts.admin')

@section('title', 'Customers - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Registered Customers</h1>
        <p style="color: #64748b; margin-top: 4px;">View customer accounts and purchase history.</p>
    </div>
</div>

<div class="table-card">
    @if($customers->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Email Address</th>
                    <th>Registered Date</th>
                    <th>Total Orders</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td><strong>{{ $customer->name }}</strong></td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="badge badge-customer">{{ $customer->orders_count }} orders</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline btn-sm">View Profile</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="padding: 20px;">
            {{ $customers->links() }}
        </div>
    @else
        <div class="empty-state">
            <p>No customer accounts registered yet.</p>
        </div>
    @endif
</div>
@endsection
