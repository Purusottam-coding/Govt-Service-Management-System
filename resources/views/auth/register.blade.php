@extends('layouts.guest')

@section('title', 'नयाँ खाता खोल्नुहोस् — बाह्रदशी गाउँपालिका')

@section('content')
<h4 class="auth-form-title">Create Citizen Account</h4>
<p class="auth-form-subtitle">बाह्रदशी गाउँपालिका अनलाइन सेवाका लागि नयाँ नागरिक दर्ता</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label fw-semibold small text-secondary">पूरा नाम (Full Name)</label>
        <div class="input-group auth-input-group">
            <span class="input-group-text"><i data-lucide="user"></i></span>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="राम बहादुर श्रेष्ठ">
        </div>
        @error('name')
            <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold small text-secondary">इमेल ठेगाना (Email)</label>
        <div class="input-group auth-input-group">
            <span class="input-group-text"><i data-lucide="mail"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="ram@example.com">
        </div>
        @error('email')
            <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label fw-semibold small text-secondary">फोन नम्बर (Phone)</label>
        <div class="input-group auth-input-group">
            <span class="input-group-text"><i data-lucide="phone"></i></span>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+९७७ ९८००००००००">
        </div>
        @error('phone')
            <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="address" class="form-label fw-semibold small text-secondary">स्थायी ठेगाना (Address)</label>
        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" placeholder="बाह्रदशी गाउँपालिका, वडा नं. ...">{{ old('address') }}</textarea>
        @error('address')
            <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-semibold small text-secondary">पासवर्ड (Password)</label>
        <div class="input-group auth-input-group">
            <span class="input-group-text"><i data-lucide="lock"></i></span>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="••••••••">
        </div>
        @error('password')
            <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label fw-semibold small text-secondary">पासवर्ड पुनः पुष्टि गर्नुहोस्</label>
        <div class="input-group auth-input-group">
            <span class="input-group-text"><i data-lucide="shield-check"></i></span>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
        </div>
    </div>

    <button type="submit" class="btn btn-auth-primary w-100 py-2 mb-3">
        <i data-lucide="user-plus" class="me-1"></i> खाता दर्ता गर्नुहोस्
    </button>

    <div class="text-center">
        <span class="text-muted small">पहिले नै खाता छ?</span>
        <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold ms-1" style="color: #78191d;">लगइन गर्नुहोस्</a>
    </div>
</form>
@endsection

