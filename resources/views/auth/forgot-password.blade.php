@extends('layouts.guest')

@section('title', 'पासवर्ड भुल्नुभयो — बाह्रदशी गाउँपालिका')

@section('content')
<h3>पासवर्ड भुल्नुभयो?</h3>
<p class="auth-subtitle">चिन्ता गर्नुहोस् नै। आफ्नो इमेल ठेगाना प्रविष्ट गर्नुहोस् र हामी ६ अङ्कको OTP कोड पठाइदिनेछौ।</p>

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
            <span class="input-group-text"><i data-lucide="mail"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
        </div>
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
        <i data-lucide="send" class="me-2"></i>Send OTP Code
    </button>

    <div class="text-center">
        <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold"><i data-lucide="arrow-left" class="me-1"></i>Back to Sign In</a>
    </div>
</form>
@endsection
