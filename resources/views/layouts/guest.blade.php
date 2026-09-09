@extends('layouts.app')

@section('body')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo-container text-center mb-4">
            <img src="{{ asset('images/Emblem_of_Nepal.png') }}" alt="Bahrdashi Gaupalikaù Logo" style="height: 50px; width: auto; margin-bottom: 12px;">
            <h4 class="mb-0">बाह्रदशी गाउँपालिका</h4>
            <p class="text-muted small">अनलाइन सेवा पोर्टल</p>
        </div>
        @yield('content')
    </div>
</div>
@endsection
