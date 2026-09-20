@extends('layouts.guest')

@section('title', 'Sign In — बाह्रदशी गाउँपालिका')

@section('content')
<h4 class="auth-form-title">Sign In to Your Account</h4>
<p class="auth-form-subtitle">गाउँ कार्यपालिकाको कार्यालय • Official Portal</p>

<!-- Quick Role Selector for Citizen & Superadmin -->
<div class="auth-role-chips mb-3">
    <button type="button" class="auth-role-chip" onclick="fillCredentials('admin@gov.np', 'password', this)">
        <i data-lucide="shield-check" style="width: 14px; height: 14px;"></i> प्रशासक (Admin)
    </button>
    <button type="button" class="auth-role-chip" onclick="fillCredentials('citizen@test.np', 'password', this)">
        <i data-lucide="user" style="width: 14px; height: 14px;"></i> नागरिक (Citizen)
    </button>
</div>

@if (session('status'))
    <div class="alert alert-success py-2 px-3 mb-3 small" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
        <div class="input-group auth-input-group">
            <span class="input-group-text"><i data-lucide="mail"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@gov.np वा citizen@test.np">
        </div>
        @error('email')
            <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" class="form-label fw-semibold small text-secondary mb-0">Password</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none small text-primary fw-semibold">पासवर्ड बिर्सनुभयो?</a>
            @endif
        </div>
        <div class="input-group auth-input-group">
            <span class="input-group-text"><i data-lucide="key-round"></i></span>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            <button type="button" class="input-group-text input-group-text-btn" id="togglePasswordBtn" onclick="togglePasswordVisibility()" title="पासवर्ड हेर्नुहोस्/लुकाउनुहोस्">
                <i data-lucide="eye" id="togglePasswordIcon"></i>
            </button>
        </div>
        @error('password')
            <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
        <label class="form-check-label small text-muted" for="remember_me">मलाई सम्झनुहोस् (Remember me)</label>
    </div>

    <button type="submit" class="btn btn-auth-primary w-100 py-2 mb-3">
        <i data-lucide="log-in" class="me-1"></i> Sign In
    </button>

    <div class="text-center">
        <span class="text-muted small">खाता छैन?</span>
        <a href="{{ route('register') }}" class="text-decoration-none small fw-semibold ms-1" style="color: #78191d;">नयाँ खाता खोल्नुहोस्</a>
    </div>
</form>

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (!passwordInput) return;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            passwordInput.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function fillCredentials(email, password, element) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;

        document.querySelectorAll('.auth-role-chip').forEach(btn => btn.classList.remove('active'));
        if (element) {
            element.classList.add('active');
        }
    }
</script>
@endpush
@endsection

