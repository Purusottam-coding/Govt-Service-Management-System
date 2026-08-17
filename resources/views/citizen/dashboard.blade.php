@extends('layouts.citizen', ['pageTitle' => 'Citizen Dashboard'])

@section('content')
<!-- Hero Welcome Banner -->
<div class="card bg-primary text-white mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #1a56db 0%, #6c5ce7 100%);">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h4>
                <p class="mb-0 opacity-90">Access online government services, apply for permits, upload documents, and track your application status easily from your portal.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('citizen.services.index') }}" class="btn btn-light fw-bold text-primary">
                    <i class="bi bi-search me-1"></i> Browse Services
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card primary">
            <div class="stat-value">{{ $stats['total_applications'] }}</div>
            <div class="stat-label">Total Applications</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card warning">
            <div class="stat-value">{{ $stats['pending_applications'] }}</div>
            <div class="stat-label">In Progress</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card success">
            <div class="stat-value">{{ $stats['approved_applications'] }}</div>
            <div class="stat-label">Approved</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card danger">
            <div class="stat-value">{{ $stats['rejected_applications'] }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Applications -->
    <div class="col-12 col-lg-8">
        <div class="card table-card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>My Recent Applications</h6>
                <a href="{{ route('citizen.applications.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>App #</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentApplications as $app)
                            <tr>
                                <td class="fw-bold text-primary">{{ $app->application_number }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $app->service->name ?? 'N/A' }}</div>
                                    <div class="small text-muted">{{ $app->service->department->name ?? '' }}</div>
                                </td>
                                <td><span class="badge-status {{ $app->getStatusBadgeClass() }}">{{ $app->getStatusLabel() }}</span></td>
                                <td>{{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : $app->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('citizen.applications.show', $app) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Track
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    You haven't submitted any applications yet.<br>
                                    <a href="{{ route('citizen.services.index') }}" class="btn btn-sm btn-primary mt-2">Apply for a Service</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Featured Services Grid -->
        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-star me-2 text-warning"></i>Popular Government Services</h6>
        <div class="row g-3">
            @foreach($featuredServices as $srv)
                <div class="col-12 col-md-6">
                    <div class="service-card">
                        <span class="service-dept">{{ $srv->department->name ?? 'Gov' }}</span>
                        <h6>{{ $srv->name }}</h6>
                        <p class="small text-muted mb-2">{{ Str::limit($srv->description, 80) }}</p>
                        <div class="service-meta">
                            <span class="service-fee">${{ number_format($srv->fee, 2) }}</span>
                            <a href="{{ route('citizen.services.show', $srv) }}" class="btn btn-sm btn-outline-primary">Apply Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Active Public Notices Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-megaphone me-2 text-primary"></i>Public Notices</h6>
            </div>
            <div class="card-body p-3">
                @forelse($activeNotices as $notice)
                    <div class="notice-card">
                        <h6 class="fw-bold mb-1 text-dark">{{ $notice->title }}</h6>
                        <span class="text-muted extra-small d-block mb-2"><i class="bi bi-calendar3 me-1"></i>{{ $notice->published_at ? $notice->published_at->format('M d, Y') : '' }}</span>
                        <p class="small text-secondary mb-0">{{ Str::limit($notice->content, 120) }}</p>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">No public announcements at this time.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
