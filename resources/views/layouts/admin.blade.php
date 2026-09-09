@extends('layouts.app')

@section('title', 'प्रशासन — ' . ($pageTitle ?? 'ड्यासबोर्ड'))

@section('body')
<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Admin Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('images/Emblem_of_Nepal.png') }}" alt="Bahrdashi Gaupalikaù Logo" style="height: 40px; width: auto;" class="me-2">

        <div>
            <h5>बाह्रदशी गाउँपालिका</h5>
            <small>प्रशासकीय कक्ष</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">मुख्य</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard"></i> ड्यासबोर्ड
        </a>

        <div class="nav-section">व्यवस्थापन</div>
        <a href="{{ route('admin.departments.index') }}" class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
            <i data-lucide="network"></i> मन्त्रालय / विभागहरू
        </a>
        <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
            <i data-lucide="settings"></i> सरकारी सेवाहरू
        </a>
        <a href="{{ route('admin.qr-codes.index') }}" class="nav-link {{ request()->routeIs('admin.qr-codes.*') ? 'active' : '' }}">
            <i data-lucide="qr-code"></i> भुक्तानी QR कोड
        </a>
        <a href="{{ route('admin.applications.index') }}" class="nav-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}">
            <i data-lucide="file-text"></i> प्राप्त निवेदनहरू
        </a>

        <div class="nav-section">नागरिकहरू</div>
        <a href="{{ route('admin.citizens.index') }}" class="nav-link {{ request()->routeIs('admin.citizens.*') ? 'active' : '' }}">
            <i data-lucide="users"></i> नागरिक सूची
        </a>

        <div class="nav-section">सञ्चार तथा सूचना</div>
        <a href="{{ route('admin.notices.index') }}" class="nav-link {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}">
            <i data-lucide="megaphone"></i> सूचनाहरू
        </a>
        <a href="{{ route('admin.feedback.index') }}" class="nav-link {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
            <i data-lucide="message-square"></i> गुनासो तथा सुझाव
        </a>
    </nav>
</aside>

<!-- Main Content -->
<div class="admin-main">
    <!-- Top Navbar -->
    <div class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" onclick="toggleSidebar()" id="sidebarToggle">
                <i data-lucide="menu"></i>
            </button>
            <h1 class="page-title">{{ $pageTitle ?? 'ड्यासबोर्ड' }}</h1>
        </div>
        <div class="navbar-user">
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="rounded-circle object-fit-cover" style="width:36px;height:36px;">
                    @else
                        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    @endif
                    <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
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

    <!-- Page Content -->
    <div class="content-area fade-in-up">
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
</div>

@push('scripts')
<script>
    function toggleSidebar() {
        document.getElementById('adminSidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
</script>
@endpush
@endsection
