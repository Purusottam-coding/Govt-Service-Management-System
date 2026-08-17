@extends('layouts.app')

@section('title', 'Online Government Service Portal')

@section('body')
<!-- Public Header Navbar -->
<nav class="navbar navbar-expand-lg citizen-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fs-4" href="{{ route('welcome') }}">
            <span class="brand-icon-sm" style="width:38px;height:38px;font-size:1.1rem;"><i class="bi bi-building"></i></span>
            GovServices
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="publicNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="#services">Public Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#notices">Notices</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About System</a>
                </li>

                @auth
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-speedometer2 me-1"></i> Go to Dashboard
                        </a>
                    </li>
                @else
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-3 fw-semibold">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary px-4 fw-bold">Register Account</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section text-center text-lg-start">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-7">
                <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-semibold text-uppercase tracking-wider mb-3">
                    <i class="bi bi-shield-check me-1"></i> Official Government Portal
                </span>
                <h1 class="display-4 fw-black">Fast, Secure & Accessible Public Services Online</h1>
                <p class="lead mb-4">Apply for driver licenses, passports, birth certificates, business permits, and housing approvals from the comfort of your home with real-time status tracking.</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    @auth
                        <a href="{{ route('citizen.services.index') }}" class="btn btn-light text-primary btn-hero">
                            <i class="bi bi-grid me-2"></i> Browse All Services
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light text-primary btn-hero">
                            <i class="bi bi-person-plus me-2"></i> Get Started Now
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-hero">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Citizen Login
                        </a>
                    @endauth
                </div>
            </div>
            <div class="col-12 col-lg-5 text-center">
                <div class="p-4 bg-white text-dark rounded-4 shadow-lg fade-in text-start border">
                    <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-lightning-charge me-2"></i>Quick Portal Features</h5>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="bg-primary-subtle text-primary p-2 rounded-3 fs-4"><i class="bi bi-file-earmark-arrow-up"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Digital Document Upload</h6>
                            <small class="text-muted">Attach required IDs, proofs, and certificates electronically.</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="bg-success-subtle text-success p-2 rounded-3 fs-4"><i class="bi bi-credit-card"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Instant Payment & Receipts</h6>
                            <small class="text-muted">Automated fee calculation with instant receipt generation.</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-purple-subtle text-purple p-2 rounded-3 fs-4" style="color:#6c5ce7;"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Live Application Tracking</h6>
                            <small class="text-muted">Step-by-step progress tracking from pending to completion.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Services Section -->
<section id="services" class="py-5">
    <div class="container py-4">
        <div class="text-center max-w-600 mx-auto mb-5">
            <span class="text-primary font-weight-bold text-uppercase tracking-wider small">Public Directory</span>
            <h2 class="fw-extrabold text-dark mt-1">Available Government Services</h2>
            <p class="text-muted">Select a service to review processing time, required documents, and fee details.</p>
        </div>

        <div class="row g-4">
            @foreach($featuredServices as $srv)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="service-card">
                        <span class="service-dept">{{ $srv->department->name ?? 'Gov Dept' }}</span>
                        <h5 class="fw-bold mb-2 text-dark">{{ $srv->name }}</h5>
                        <p class="small text-muted mb-3 flex-grow-1">{{ Str::limit($srv->description, 90) }}</p>
                        <div class="service-meta">
                            <span class="service-fee">{{ $srv->fee > 0 ? '$' . number_format($srv->fee, 2) : 'Free' }}</span>
                            @auth
                                <a href="{{ route('citizen.services.show', $srv) }}" class="btn btn-sm btn-outline-primary">Apply Now</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Apply Now</a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Public Notices Section -->
<section id="notices" class="py-5 bg-white border-top border-bottom">
    <div class="container py-3">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-5">
                <span class="text-primary font-weight-bold text-uppercase tracking-wider small">Official Announcements</span>
                <h2 class="fw-bold text-dark mt-1 mb-3">Latest News & Public Notices</h2>
                <p class="text-secondary mb-4">Stay informed regarding scheduled service updates, holiday office schedules, and system enhancements.</p>
                <div class="card p-3 bg-light border-0">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-headset fs-2 text-primary"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Need Citizen Support?</h6>
                            <span class="small text-muted">Submit an inquiry or feedback ticket through your citizen account.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                @foreach($publicNotices as $notice)
                    <div class="notice-card">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="fw-bold text-dark mb-0">{{ $notice->title }}</h6>
                            <span class="text-muted extra-small"><i class="bi bi-calendar3 me-1"></i>{{ $notice->published_at ? $notice->published_at->format('M d, Y') : '' }}</span>
                        </div>
                        <p class="small text-muted mb-0">{{ $notice->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p class="small mb-0 text-muted">&copy; {{ date('Y') }} Online Government Service Management System. All Rights Reserved.</p>
    </div>
</footer>
@endsection
