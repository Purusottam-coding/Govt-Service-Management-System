@extends('layouts.guest')

@section('title', 'नयाँ खाता खोल्नुहोस् — नेपाल सरकार')

@section('content')
<h3>नयाँ खाता दर्ता</h3>
<p class="auth-subtitle">नेपाल सरकार अनलाइन सेवाका लागि नागरिक खाता खोल्नुहोस्</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">पूरा नाम</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="राम बहादुर श्रेष्ठ">
        </div>
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">इमेल ठेगाना</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="ram@example.com">
        </div>
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">फोन नम्बर</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+९७७ ९८००००००००">
        </div>
        @error('phone')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">स्थायी / अस्थायी ठेगाना</label>
        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" placeholder="काठमाडौँ महानगरपालिका, वडा नं. १०">{{ old('address') }}</textarea>
        @error('address')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">पासवर्ड</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="••••••••">
        </div>
        @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">पासवर्ड पुनः पुष्टि गर्नुहोस्</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
        <i class="bi bi-person-plus me-2"></i>खाता दर्ता गर्नुहोस्
    </button>

    <div class="text-center">
        <span class="text-muted small">पहिले नै खाता छ?</span>
        <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold">लगइन गर्नुहोस्</a>
    </div>
</form>
@endsection
