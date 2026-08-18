<section>
    <header class="mb-4">
        <h5 class="fw-bold text-dark">
            व्यक्तिगत विवरण (Profile Information)
        </h5>
        <p class="text-muted small">
            तपाईंको खाताको प्रोफाइल विवरण र इमेल ठेगाना अद्यावधिक गर्नुहोस्।
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-3">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">पूरा नाम <span class="text-danger">*</span></label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">इमेल ठेगाना <span class="text-danger">*</span></label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 alert alert-warning py-2 small">
                    तपाईंको इमेल ठेगाना प्रमाणित गरिएको छैन।
                    <button form="send-verification" class="btn btn-link p-0 text-decoration-underline small">
                        प्रमाणीकरण इमेल पुनः पठाउन यहाँ क्लिक गर्नुहोस्।
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-2 text-success fw-bold">
                            नयाँ प्रमाणीकरण लिङ्क तपाईंको इमेल ठेगानामा पठाइएको छ।
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> सुरक्षित गर्नुहोस्</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small fw-semibold"><i class="bi bi-check-circle-fill me-1"></i>विवरण सुरक्षित गरियो।</span>
            @endif
        </div>
    </form>
</section>
