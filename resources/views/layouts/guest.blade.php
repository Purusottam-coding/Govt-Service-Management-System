@extends('layouts.app')

@section('body')
<div class="auth-split-wrapper">
    <!-- Left Hero Showcase Pane -->
    <div class="auth-hero-pane">
        <div class="auth-hero-overlay"></div>
        <div class="auth-hero-content">
            <div class="auth-hero-emblem">
                <img src="{{ asset('images/Emblem_of_Nepal.png') }}" alt="Nepal Government Logo">
            </div>
            <h1 class="auth-hero-title-np">बाह्रदशी गाउँपालिका</h1>
            <h2 class="auth-hero-title-en">Barhadashi Rural Municipality</h2>
            <p class="auth-hero-sub-np">गाउँ कार्यपालिकाको कार्यालय</p>
            <p class="auth-hero-sub-en">Office of the Rural Municipal Executive</p>
            <div class="auth-hero-meta">
                <span>अनलाइन सेवा व्यवस्थापन प्रणाली</span>
                <span class="auth-hero-separator">•</span>
                <span>झापा, कोशी प्रदेश, नेपाल</span>
            </div>
        </div>
    </div>

    <!-- Right Form Pane -->
    <div class="auth-form-pane">
        <div class="auth-form-container">
            <div class="auth-card-box">
                <!-- Crimson Header Box -->
                <div class="auth-card-header">
                    <div class="auth-header-emblem">
                        <img src="{{ asset('images/Emblem_of_Nepal.png') }}" alt="Nepal Government Emblem">
                    </div>
                    <h4 class="auth-header-title-np">बाह्रदशी गाउँपालिका</h4>
                    <p class="auth-header-title-en">Barhadashi Rural Municipality</p>
                    <span class="auth-header-badge">नागरिक तथा कर्मचारी सेवा पोर्टल</span>
                </div>

                <!-- Card Content -->
                <div class="auth-card-body">
                    @yield('content')
                </div>
            </div>

            <!-- Footer Links -->
            <div class="auth-footer-links">
                <a href="{{ route('welcome') }}" class="auth-footer-link">
                    <i data-lucide="arrow-left" class="me-1"></i>गृहपृष्ठमा फर्कनुहोस्
                </a>
                <span class="auth-footer-separator">•</span>
                <a href="{{ route('welcome') }}#services" class="auth-footer-link">सेवाहरू</a>
                <span class="auth-footer-separator">•</span>
                <a href="{{ route('welcome') }}#about" class="auth-footer-link">प्रणालीको बारेमा</a>
            </div>
        </div>
    </div>
</div>
@endsection

