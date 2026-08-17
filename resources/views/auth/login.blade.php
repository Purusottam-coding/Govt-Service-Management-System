@extends('layouts.guest')

@section('title', 'Login — GovServices')

@section('content')
<h3>Welcome Back</h3>
<p class="auth-subtitle">Sign in to your GovServices account</p>

@if (session('status'))
    <div class="alert alert-success mb-3" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
        </div>
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" class="form-label mb-0">Password</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none small">Forgot?</a>
            @endif
        </div>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
        </div>
        @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
        <label class="form-check-label small" for="remember_me">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
    </button>

    <div class="text-center">
        <span class="text-muted small">Don't have an account?</span>
        <a href="{{ route('register') }}" class="text-decoration-none small fw-semibold">Register here</a>
    </div>
</form>
@endsection
