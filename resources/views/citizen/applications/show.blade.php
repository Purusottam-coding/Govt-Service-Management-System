@extends('layouts.citizen', ['pageTitle' => 'Application Details'])

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('citizen.applications.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to My Applications
    </a>
    @if($application->payment)
        <a href="{{ route('citizen.payments.receipt', $application) }}" class="btn btn-sm btn-outline-success">
            <i class="bi bi-receipt me-1"></i> View Receipt
        </a>
    @elseif(($application->service->fee ?? 0) > 0)
        <a href="{{ route('citizen.payments.create', $application) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-credit-card me-1"></i> Pay Fee (${{ number_format($application->service->fee, 2) }})
        </a>
    @endif
</div>

<!-- Visual Status Tracker -->
<div class="card mb-4 p-4 bg-white">
    <h6 class="fw-bold text-center mb-3">Application Progress Status</h6>

    <ul class="status-tracker">
        <li class="step {{ in_array($application->status, ['pending', 'under_review', 'approved', 'completed']) ? 'completed' : '' }}">
            <div class="step-icon"><i class="bi bi-send-check"></i></div>
            <div class="step-label">Submitted</div>
        </li>
        <li class="step {{ in_array($application->status, ['under_review', 'approved', 'completed']) ? 'completed' : ($application->status == 'pending' ? 'active' : '') }}">
            <div class="step-icon"><i class="bi bi-search"></i></div>
            <div class="step-label">Under Review</div>
        </li>
        @if($application->status == 'rejected')
            <li class="step rejected">
                <div class="step-icon"><i class="bi bi-x-circle"></i></div>
                <div class="step-label">Rejected</div>
            </li>
        @else
            <li class="step {{ in_array($application->status, ['approved', 'completed']) ? 'completed' : '' }}">
                <div class="step-icon"><i class="bi bi-check-lg"></i></div>
                <div class="step-label">Approved</div>
            </li>
            <li class="step {{ $application->status == 'completed' ? 'completed' : '' }}">
                <div class="step-icon"><i class="bi bi-award"></i></div>
                <div class="step-label">Completed</div>
            </li>
        @endif
    </ul>
</div>

<div class="row g-4">
    <!-- Main Info -->
    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Application #{{ $application->application_number }}</h6>
                <span class="badge-status {{ $application->getStatusBadgeClass() }}">{{ $application->getStatusLabel() }}</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-4">
                        <span class="text-muted small d-block">Service Name</span>
                        <span class="fw-bold text-dark">{{ $application->service->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="text-muted small d-block">Department</span>
                        <span class="fw-semibold">{{ $application->service->department->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="text-muted small d-block">Submitted On</span>
                        <span class="fw-semibold">{{ $application->submitted_at ? $application->submitted_at->format('M d, Y h:i A') : $application->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                @if($application->admin_remarks)
                    <div class="alert alert-info mb-4">
                        <h6 class="fw-bold mb-1"><i class="bi bi-info-circle me-1"></i> Admin Remarks / Official Note:</h6>
                        <p class="mb-0 small" style="white-space: pre-line;">{{ $application->admin_remarks }}</p>
                    </div>
                @endif

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-file-earmark-check me-2 text-primary"></i>Uploaded Documents</h6>
                @if($application->documents->count() > 0)
                    <div class="list-group mb-4">
                        @foreach($application->documents as $doc)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                                    <div>
                                        <span class="fw-semibold text-dark small d-block">{{ $doc->document_name }}</span>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-3 bg-light rounded text-muted small mb-4">No documents were uploaded for this application.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Summary Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-credit-card me-2 text-primary"></i>Payment & Fees</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Required Fee:</span>
                    <span class="fw-bold text-dark">${{ number_format($application->service->fee ?? 0, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Payment Status:</span>
                    @if($application->payment)
                        <span class="badge bg-success">Paid</span>
                    @elseif(($application->service->fee ?? 0) > 0)
                        <span class="badge bg-warning text-dark">Unpaid</span>
                    @else
                        <span class="badge bg-light text-muted">Free</span>
                    @endif
                </div>

                @if(!$application->payment && ($application->service->fee ?? 0) > 0)
                    <a href="{{ route('citizen.payments.create', $application) }}" class="btn btn-warning w-100 fw-bold">
                        <i class="bi bi-credit-card me-1"></i> Make Payment Now
                    </a>
                @endif

                @if($application->payment)
                    <hr>
                    <div class="small">
                        <div><strong>Transaction ID:</strong> {{ $application->payment->transaction_id }}</div>
                        <div><strong>Paid Date:</strong> {{ $application->payment->paid_at ? $application->payment->paid_at->format('M d, Y') : '' }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
