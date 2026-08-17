@extends('layouts.guest')

@section('title', 'Forgot Password — GovServices')

@section('content')
<h3>Forgot Password?</h3>
<p class="auth-subtitle">No problem. Enter your email address and we will email you a password reset link.</p>

@if (session('status'))
    <div class="alert alert-success mb-3" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
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

    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
        <i class="bi bi-send me-2"></i>Email Password Reset Link
    </button>

    <div class="text-center">
        <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold"><i class="bi bi-arrow-left me-1"></i>Back to Sign In</a>
    </div>
</form>
@endsection
