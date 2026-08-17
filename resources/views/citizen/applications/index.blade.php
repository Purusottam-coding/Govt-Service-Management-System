@extends('layouts.citizen', ['pageTitle' => 'My Applications'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">My Submitted Applications</h4>
        <span class="text-muted small">View all your past and active government service applications</span>
    </div>
    <a href="{{ route('citizen.applications.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> New Application
    </a>
</div>

<!-- Filters -->
<div class="card mb-4 p-3 bg-white border-0 shadow-sm">
    <form action="{{ route('citizen.applications.index') }}" method="GET" class="row g-2">
        <div class="col-12 col-md-9">
            <select name="status" class="form-select">
                <option value="">All Application Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-filter"></i> Filter</button>
            @if(request()->filled('status'))
                <a href="{{ route('citizen.applications.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-x-lg"></i></a>
            @endif
        </div>
    </form>
</div>

<div class="card table-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Application #</th>
                    <th>Service Name</th>
                    <th>Department</th>
                    <th>Fee Status</th>
                    <th>Status</th>
                    <th>Submitted On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td class="fw-bold text-primary">{{ $app->application_number }}</td>
                        <td class="fw-semibold">{{ $app->service->name ?? 'N/A' }}</td>
                        <td>{{ $app->service->department->name ?? 'N/A' }}</td>
                        <td>
                            @if($app->payment)
                                <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold">Paid</span>
                            @elseif(($app->service->fee ?? 0) > 0)
                                <a href="{{ route('citizen.payments.create', $app) }}" class="badge bg-warning-subtle text-warning border border-warning-subtle text-decoration-none fw-semibold">
                                    Pay ${{ number_format($app->service->fee, 2) }}
                                </a>
                            @else
                                <span class="badge bg-light text-muted border">Free</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status {{ $app->getStatusBadgeClass() }}">{{ $app->getStatusLabel() }}</span>
                        </td>
                        <td>{{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : $app->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('citizen.applications.show', $app) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i> Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-2 d-block mb-2 text-muted"></i>
                            No applications found matching criteria.<br>
                            <a href="{{ route('citizen.applications.create') }}" class="btn btn-sm btn-primary mt-2">Submit New Application</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($applications->hasPages())
        <div class="card-footer bg-white">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
