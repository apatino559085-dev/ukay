@extends('layouts.app')

@section('title', 'Register - THRIFT FINDS')

@section('content')
<section class="section">
    <div class="container" style="max-width: 440px;">
        <div class="section-header">
            <h1 class="section-title">Create Account</h1>
            <p style="color: var(--secondary); margin-top: 8px;">Register with your Gmail to shop ukay finds & checkout</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name') }}" placeholder="Juan Dela Cruz" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Gmail / Email Address *</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ old('email') }}" placeholder="yourname@gmail.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password *</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>

            <p class="text-center mt-3" style="font-size: 13px; color: var(--secondary);">
                Already have an account? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600;">Login here</a>
            </p>
        </form>
    </div>
</section>
@endsection
