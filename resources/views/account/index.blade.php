@extends('layouts.app')

@section('title', 'My Account - ThreadLine')

@section('content')
<div class="page-header">
    <h1>My Account</h1>
</div>

<section class="section">
    <div class="container">
        <div class="account-grid">
            {{-- Sidebar --}}
            <div class="account-sidebar">
                <ul class="account-nav">
                    <li><a href="#profile" class="active">Profile</a></li>
                    <li><a href="#orders">Order History</a></li>
                    <li><a href="#password">Change Password</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="#" onclick="this.closest('form').submit();" style="color: var(--danger);">Logout</a>
                        </form>
                    </li>
                </ul>
            </div>

            {{-- Content --}}
            <div class="account-content">
                {{-- Profile Section --}}
                <div id="profile" class="mb-4">
                    <h2 style="font-family: var(--font-heading); font-size: 20px; margin-bottom: 24px;">Profile Information</h2>

                    <form method="POST" action="{{ route('account.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" name="city" id="city" class="form-control"
                                       value="{{ old('city', $user->city) }}">
                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <input type="text" name="province" id="province" class="form-control"
                                       value="{{ old('province', $user->province) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control"
                                   value="{{ old('postal_code', $user->postal_code) }}" style="max-width: 200px;">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>

                {{-- Order History --}}
                <div id="orders" class="mb-4" style="border-top: 1px solid var(--border); padding-top: 40px;">
                    <h2 style="font-family: var(--font-heading); font-size: 20px; margin-bottom: 24px;">Order History</h2>

                    @if($orders->count() > 0)
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $order->status }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('account.order', $order) }}" class="btn btn-sm btn-outline">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state" style="padding: 40px;">
                            <p>You haven't placed any orders yet.</p>
                            <a href="{{ route('shop') }}" class="btn btn-outline mt-2">Start Shopping</a>
                        </div>
                    @endif
                </div>

                {{-- Change Password --}}
                <div id="password" style="border-top: 1px solid var(--border); padding-top: 40px;">
                    <h2 style="font-family: var(--font-heading); font-size: 20px; margin-bottom: 24px;">Change Password</h2>

                    <form method="POST" action="{{ route('account.password') }}" style="max-width: 400px;">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
