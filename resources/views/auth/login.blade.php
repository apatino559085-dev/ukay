@extends('layouts.app')

@section('title', 'Login - THRIFT FINDS')

@section('content')
<section class="section">
    <div class="container" style="max-width: 440px;">
        <div class="section-header">
            <h1 class="section-title">Customer Login</h1>
            <p style="color: var(--secondary); margin-top: 8px;">Log in with your Gmail / Account to shop ukay finds & add items to cart</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Gmail / Email Address *</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ old('email') }}" placeholder="yourname@gmail.com" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="text-transform: none; letter-spacing: 0; font-weight: 400; font-size: 13px;">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Login to Account</button>

            <p class="text-center mt-3" style="font-size: 13px; color: var(--secondary);">
                Don't have an account yet? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600;">Create New Account</a>
            </p>
        </form>
    </div>
</section>
@endsection
