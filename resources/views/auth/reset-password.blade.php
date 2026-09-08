@extends('layouts.guest')

@section('title', 'Reset Password — GovServices')

@section('content')
<h3>Reset Password</h3>
@if(!($otpVerified ?? false))
    <p class="auth-subtitle">Enter the 6-digit OTP sent to your email address.</p>
@else
    <p class="auth-subtitle">OTP verified. Create your new password below.</p>
@endif

@if (session('status'))
    <div class="alert alert-success mb-3" role="alert">
        {{ session('status') }}
    </div>
@endif

@if(!($otpVerified ?? false))
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i data-lucide="mail"></i></span>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $resetEmail ?? '') }}" required readonly>
            </div>
        </div>

        <div class="mb-3">
            <label for="otp" class="form-label">OTP Code</label>
            <div class="input-group">
                <span class="input-group-text"><i data-lucide="shield-check"></i></span>
                <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp" value="{{ old('otp') }}" required autofocus placeholder="Enter 6-digit code" maxlength="6" inputmode="numeric">
            </div>
            @error('otp')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
            <i data-lucide="check" class="me-2"></i>Verify OTP
        </button>
    </form>
@else
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i data-lucide="mail"></i></span>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $resetEmail ?? '') }}" required readonly>
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <div class="input-group">
                <span class="input-group-text"><i data-lucide="lock"></i></span>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="••••••••">
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i data-lucide="shield"></i></span>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
            <i data-lucide="check" class="me-2"></i>Reset Password
        </button>
    </form>
@endif
@endsection
