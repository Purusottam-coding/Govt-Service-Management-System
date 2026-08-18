@extends('layouts.app')

@section('title', ($pageTitle ?? 'ड्यासबोर्ड') . ' — नेपाल सरकार')

@section('body')
<!-- Citizen Navbar -->
<nav class="navbar navbar-expand-lg citizen-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('citizen.dashboard') }}">
            <span class="brand-icon-sm"><i class="bi bi-building"></i></span>
            नेपाल सरकार
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#citizenNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="citizenNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('citizen.dashboard') ? 'active' : '' }}" href="{{ route('citizen.dashboard') }}">
                        <i class="bi bi-grid me-1"></i>ड्यासबोर्ड
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('citizen.services.*') ? 'active' : '' }}" href="{{ route('citizen.services.index') }}">
                        <i class="bi bi-gear me-1"></i>सरकारी सेवाहरू
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('citizen.applications.*') ? 'active' : '' }}" href="{{ route('citizen.applications.index') }}">
                        <i class="bi bi-file-earmark-text me-1"></i>मेरा निवेदनहरू
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('citizen.feedback.*') ? 'active' : '' }}" href="{{ route('citizen.feedback.index') }}">
                        <i class="bi bi-chat-dots me-1"></i>गुनासो / सुझाव
                    </a>
                </li>
            </ul>
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <div class="user-avatar" style="width:30px;height:30px;font-size:.75rem;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <span>{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>प्रोफाइल</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>लगआउट</button>
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
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
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
@endsection
