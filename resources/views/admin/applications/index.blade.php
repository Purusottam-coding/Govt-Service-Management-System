@extends('layouts.admin', ['pageTitle' => 'Manage Applications'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 font-weight-bold">Citizen Applications</h5>
        <span class="text-muted small">Review, track, and update status of submitted applications</span>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4 p-3 bg-light border-0 shadow-sm">
    <form action="{{ route('admin.applications.index') }}" method="GET" class="row g-2">
        <div class="col-12 col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by App #, name, or email..." value="{{ request('search') }}">
        </div>
        <div class="col-12 col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <select name="service_id" class="form-select">
                <option value="">All Services</option>
                @foreach($services as $srv)
                    <option value="{{ $srv->id }}" {{ request('service_id') == $srv->id ? 'selected' : '' }}>
                        {{ $srv->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-search"></i> Filter</button>
            @if(request()->hasAny(['search', 'status', 'service_id']))
                <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-x-lg"></i></a>
            @endif
        </div>
    </form>
</div>

<!-- Table -->
<div class="card table-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>App Number</th>
                    <th>Applicant</th>
                    <th>Service / Department</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td class="fw-bold text-primary">{{ $app->application_number }}</td>
                        <td>
                            <div class="fw-semibold">{{ $app->applicant_name }}</div>
                            <div class="small text-muted">{{ $app->applicant_email }}</div>
                        </td>
                        <td>
                            <div class="fw-medium">{{ $app->service->name ?? 'N/A' }}</div>
                            <div class="small text-muted">{{ $app->service->department->name ?? 'N/A' }}</div>
                        </td>
                        <td>
                            @if($app->payment)
                                <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold">
                                    <i class="bi bi-check-circle me-1"></i>Paid (${{ number_format($app->payment->amount, 2) }})
                                </span>
                            @elseif(($app->service->fee ?? 0) > 0)
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle fw-semibold">
                                    <i class="bi bi-clock me-1"></i>Unpaid (${{ number_format($app->service->fee, 2) }})
                                </span>
                            @else
                                <span class="badge bg-light text-muted border">Free</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status {{ $app->getStatusBadgeClass() }}">
                                {{ $app->getStatusLabel() }}
                            </span>
                        </td>
                        <td>
                            <div class="small">{{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : $app->created_at->format('M d, Y') }}</div>
                            <div class="small text-muted">{{ $app->submitted_at ? $app->submitted_at->format('h:i A') : '' }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-sm btn-action btn-outline-primary">
                                <i class="bi bi-eye me-1"></i> Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No applications found matching criteria.</td>
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
