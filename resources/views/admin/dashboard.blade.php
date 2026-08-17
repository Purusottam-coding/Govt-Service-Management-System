@extends('layouts.admin', ['pageTitle' => 'Dashboard Overview'])

@section('content')
<!-- Stat Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($stats['total_applications']) }}</div>
                    <div class="stat-label">Total Applications</div>
                </div>
                <div class="stat-icon primary"><i class="bi bi-file-earmark-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($stats['pending_applications']) }}</div>
                    <div class="stat-label">Pending Review</div>
                </div>
                <div class="stat-icon warning"><i class="bi bi-clock-history"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($stats['approved_applications']) }}</div>
                    <div class="stat-label">Approved</div>
                </div>
                <div class="stat-icon success"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($stats['total_citizens']) }}</div>
                    <div class="stat-label">Registered Citizens</div>
                </div>
                <div class="stat-icon info"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <h4 class="fw-bold mb-1 text-primary">{{ $stats['total_departments'] }}</h4>
            <span class="text-muted small">Departments</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <h4 class="fw-bold mb-1 text-success">{{ $stats['total_services'] }}</h4>
            <span class="text-muted small">Active Services</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <h4 class="fw-bold mb-1 text-purple" style="color:#6c5ce7;">{{ $stats['completed_applications'] }}</h4>
            <span class="text-muted small">Completed</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <h4 class="fw-bold mb-1 text-danger">{{ $stats['pending_feedback'] }}</h4>
            <span class="text-muted small">Open Feedback</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Applications Table -->
    <div class="col-12 col-xl-8">
        <div class="card table-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-earmark-text me-2 text-primary"></i>Recent Applications</span>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>App #</th>
                            <th>Applicant</th>
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
                                    <div class="fw-semibold">{{ $app->applicant_name }}</div>
                                    <div class="small text-muted">{{ $app->applicant_email }}</div>
                                </td>
                                <td>{{ $app->service->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge-status {{ $app->getStatusBadgeClass() }}">
                                        {{ $app->getStatusLabel() }}
                                    </span>
                                </td>
                                <td>{{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : $app->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-sm btn-action btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No applications submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Feedback Widget -->
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-chat-dots me-2 text-primary"></i>Citizen Feedback</span>
                <a href="{{ route('admin.feedback.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentFeedback as $fb)
                        <a href="{{ route('admin.feedback.show', $fb) }}" class="list-group-item list-group-item-action p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0 fw-semibold text-dark">{{ $fb->subject }}</h6>
                                <span class="badge-status {{ $fb->getStatusBadgeClass() }}">{{ ucfirst($fb->status) }}</span>
                            </div>
                            <p class="small text-muted mb-1 text-truncate">{{ $fb->message }}</p>
                            <div class="small text-secondary fw-medium">By: {{ $fb->user->name ?? 'Citizen' }}</div>
                        </a>
                    @empty
                        <div class="p-4 text-center text-muted">No feedback received yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection