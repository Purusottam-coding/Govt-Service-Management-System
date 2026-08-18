@extends('layouts.app')

@section('title', 'अनलाइन सरकारी सेवा पोर्टल')

@section('body')
<!-- Public Header Navbar -->
<nav class="navbar navbar-expand-lg citizen-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fs-4" href="{{ route('welcome') }}">
            <span class="brand-icon-sm" style="width:38px;height:38px;font-size:1.1rem;"><i class="bi bi-building"></i></span>
            नेपाल सरकार
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="publicNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="#services">सरकारी सेवाहरू</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#notices">सूचनाहरू</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">प्रणालीको बारेमा</a>
                </li>

                @auth
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-speedometer2 me-1"></i> ड्यासबोर्डमा जानुहोस्
                        </a>
                    </li>
                @else
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-3 fw-semibold">साइन इन</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary px-4 fw-bold">खाता खोल्नुहोस्</a>
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
                    <i class="bi bi-shield-check me-1"></i> नेपाल सरकारको आधिकारिक पोर्टल
                </span>
                <h1 class="display-4 fw-black">छरितो, सुरक्षित र सुलभ अनलाइन सरकारी सेवाहरू</h1>
                <p class="lead mb-4">सवारी चालक अनुमतिपत्र, राहदानी, जन्म दर्ता, विवाह दर्ता, व्यावसायिक इजाजत पत्र तथा घर नक्सा स्वीकृतिका लागि घरैबाट अनलाइन आवेदन दिनुहोस् र प्रत्यक्ष ट्र्याकिङ गर्नुहोस्।</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    @auth
                        <a href="{{ route('citizen.services.index') }}" class="btn btn-light text-primary btn-hero">
                            <i class="bi bi-grid me-2"></i> सबै सेवाहरू हेर्नुहोस्
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light text-primary btn-hero">
                            <i class="bi bi-person-plus me-2"></i> आवेदन सुरु गर्नुहोस्
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-hero">
                            <i class="bi bi-box-arrow-in-right me-2"></i> नागरिक लगइन
                        </a>
                    @endauth
                </div>
            </div>
            <div class="col-12 col-lg-5 text-center">
                <div class="p-4 bg-white text-dark rounded-4 shadow-lg fade-in text-start border">
                    <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-lightning-charge me-2"></i>मुख्य सुविधाहरू</h5>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="bg-primary-subtle text-primary p-2 rounded-3 fs-4"><i class="bi bi-file-earmark-arrow-up"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">डिजिटल कागजात अपलोड</h6>
                            <small class="text-muted">आवश्यक नागरिकता, फोटो र अन्य प्रमाण-पत्रहरू अनलाइन सुरक्षित अपलोड गर्नुहोस्।</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="bg-success-subtle text-success p-2 rounded-3 fs-4"><i class="bi bi-credit-card"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">तत्काल डिजिटल भुक्तानी र रसिद</h6>
                            <small class="text-muted">सरकारी दस्तुर अनलाइन भुक्तानी गरी तत्काल कम्प्युटरकृत रसिद प्राप्त गर्नुहोस्।</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-purple-subtle text-purple p-2 rounded-3 fs-4" style="color:#6c5ce7;"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">प्रत्यक्ष आवेदन ट्र्याकिङ</h6>
                            <small class="text-muted">आफ्नो निवेदनको अवस्था पेश गरिएको देखि स्वीकृत हुनेसम्म प्रत्यक्ष हेर्नुहोस्।</small>
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
            <span class="text-primary font-weight-bold text-uppercase tracking-wider small">सार्वजनिक सेवा सूची</span>
            <h2 class="fw-extrabold text-dark mt-1">उपलब्ध सरकारी सेवाहरू</h2>
            <p class="text-muted">आवश्यक कागजात, दस्तुर तथा प्रशोधन समय हेरी अनलाइन आवेदन दिनुहोस्।</p>
        </div>

        <div class="row g-4">
            @foreach($featuredServices as $srv)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="service-card">
                        <span class="service-dept">{{ $srv->department->name ?? 'नेपाल सरकार' }}</span>
                        <h5 class="fw-bold mb-2 text-dark">{{ $srv->name }}</h5>
                        <p class="small text-muted mb-3 flex-grow-1">{{ Str::limit($srv->description, 90) }}</p>
                        <div class="service-meta">
                            <span class="service-fee">{{ $srv->fee > 0 ? 'रु. ' . number_format($srv->fee, 2) : 'निःशुल्क' }}</span>
                            @auth
                                <a href="{{ route('citizen.services.show', $srv) }}" class="btn btn-sm btn-outline-primary">आवेदन दिनुहोस्</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">आवेदन दिनुहोस्</a>
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
                <span class="text-primary font-weight-bold text-uppercase tracking-wider small">आधिकारिक सूचनाहरू</span>
                <h2 class="fw-bold text-dark mt-1 mb-3">ताजा सूचना तथा समाचार</h2>
                <p class="text-secondary mb-4">सरकारी सेवाहरू, नयाँ नियमहरू, सार्वजनिक बिदा तथा प्रणाली अपडेटसम्बन्धी सूचनाहरू।</p>
                <div class="card p-3 bg-light border-0">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-headset fs-2 text-primary"></i>
                        <div>
                            <h6 class="fw-bold mb-0">सहयोग वा सोधपुछ चाहिएमा?</h6>
                            <span class="small text-muted">आफ्नो नागरिक खाता मार्फत सुझाव वा गुनासो पेश गर्न सक्नुहुन्छ।</span>
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
        <p class="small mb-0 text-muted">&copy; {{ date('Y') }} नेपाल सरकार — अनलाइन सरकारी सेवा प्रणाली। सर्वाधिकार सुरक्षित।</p>
    </div>
</footer>
@endsection
