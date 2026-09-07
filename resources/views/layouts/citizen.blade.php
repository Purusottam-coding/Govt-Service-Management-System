@extends('layouts.app')

@section('title', ($pageTitle ?? 'ड्यासबोर्ड') . ' — नेपाल सरकार')

@section('body')
<!-- Citizen Navbar -->
<nav class="navbar navbar-expand-lg citizen-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('citizen.dashboard') }}">
            <span class="brand-icon-sm"><i data-lucide="building-2"></i></span>
            नेपाल सरकार
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#citizenNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="citizenNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('citizen.dashboard') ? 'active' : '' }}" href="{{ route('citizen.dashboard') }}">
                        <i data-lucide="grid" class="me-1"></i>ड्यासबोर्ड
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('citizen.services.*') ? 'active' : '' }}" href="{{ route('citizen.services.index') }}">
                        <i data-lucide="settings" class="me-1"></i>सरकारी सेवाहरू
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('citizen.applications.*') ? 'active' : '' }}" href="{{ route('citizen.applications.index') }}">
                        <i data-lucide="file-text" class="me-1"></i>मेरा निवेदनहरू
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('citizen.feedback.*') ? 'active' : '' }}" href="{{ route('citizen.feedback.index') }}">
                        <i data-lucide="message-square" class="me-1"></i>गुनासो / सुझाव
                    </a>
                </li>
            </ul>
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="rounded-circle object-fit-cover" style="width:30px;height:30px;">
                    @else
                        <div class="user-avatar" style="width:30px;height:30px;font-size:.75rem;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    @endif
                    <span>{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i data-lucide="user" class="me-2"></i>प्रोफाइल</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i data-lucide="log-out" class="me-2"></i>लगआउट</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="citizen-main fade-in-up">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i data-lucide="check-circle" class="me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i data-lucide="alert-triangle" class="me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i data-lucide="info" class="me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i data-lucide="alert-triangle" class="me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

@if(session('payment_verification_popup'))
    <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="verificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success-subtle">
                    <h5 class="modal-title fw-bold" id="verificationModalLabel">
                        <i data-lucide="badge-check" class="me-1"></i> भुक्तानी सूचना
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('payment_verification_popup_message', 'तपाईंको भुक्तानी प्रमाण verification process मा पठाइएको छ।') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">ठीक छ</button>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
@if(session('payment_verification_popup'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('verificationModal');
        if (!modalElement) {
            return;
        }

        const verificationModal = new bootstrap.Modal(modalElement);
        verificationModal.show();
    });
</script>
@endif
@endpush
