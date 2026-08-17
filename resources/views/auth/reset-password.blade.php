@extends('layouts.guest')

@section('title', 'Reset Password — GovServices')

@section('content')
<h3>Reset Password</h3>
<p class="auth-subtitle">Enter your new password below.</p>

<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus readonly>
        </div>
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="••••••••">
        </div>
        @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
        <i class="bi bi-check-lg me-2"></i>Reset Password
    </button>
</form>
@endsection
