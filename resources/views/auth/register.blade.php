@extends('layouts.guest')

@section('title', 'Register — GovServices')

@section('content')
<h3>Create Account</h3>
<p class="auth-subtitle">Register for citizen government services</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
        </div>
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com">
        </div>
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 234 567 8900">
        </div>
        @error('phone')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Residential Address</label>
        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" placeholder="Street, City, Zip Code">{{ old('address') }}</textarea>
        @error('address')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="••••••••">
        </div>
        @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
        <i class="bi bi-person-plus me-2"></i>Register
    </button>

    <div class="text-center">
        <span class="text-muted small">Already have an account?</span>
        <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold">Sign in</a>
    </div>
</form>
@endsection
