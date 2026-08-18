@extends('layouts.admin', ['pageTitle' => 'Application Review'])

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Applications
    </a>
</div>

<div class="row g-4">
    <!-- Application Details & Documents -->
    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-file-earmark-person me-2 text-primary"></i>Application #{{ $application->application_number }}</h6>
                <span class="badge-status {{ $application->getStatusBadgeClass() }}">{{ $application->getStatusLabel() }}</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <span class="text-muted small d-block">Service Requested</span>
                        <span class="fw-bold text-dark">{{ $application->service->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <span class="text-muted small d-block">Department</span>
                        <span class="fw-semibold">{{ $application->service->department->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <span class="text-muted small d-block">Submitted Date</span>
                        <span class="fw-semibold">{{ $application->submitted_at ? $application->submitted_at->format('M d, Y h:i A') : $application->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <span class="text-muted small d-block">Processed Date</span>
                        <span class="fw-semibold">{{ $application->processed_at ? $application->processed_at->format('M d, Y') : 'Not processed yet' }}</span>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person me-2 text-primary"></i>Applicant Details</h6>
                <div class="row g-3 mb-4 bg-light p-3 rounded">
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Full Name</span>
                        <span class="fw-semibold text-dark">{{ $application->applicant_name }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Email Address</span>
                        <span class="fw-semibold text-dark">{{ $application->applicant_email }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Phone Number</span>
                        <span class="fw-semibold text-dark">{{ $application->applicant_phone ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Address</span>
                        <span class="fw-semibold text-dark">{{ $application->applicant_address ?? 'N/A' }}</span>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-file-earmark-check me-2 text-primary"></i>Uploaded Documents</h6>
                @if($application->documents->count() > 0)
                    <div class="row g-2 mb-4">
                        @foreach($application->documents as $doc)
                            <div class="col-12 col-md-6">
                                <div class="p-3 border rounded d-flex justify-content-between align-items-center bg-white">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-pdf fs-4 text-danger"></i>
                                        <div>
                                            <div class="fw-semibold small">{{ $doc->document_name }}</div>
                                            <span class="text-muted extra-small">Uploaded</span>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-3 bg-light rounded text-muted small mb-4">No documents uploaded for this application.</div>
                @endif

                @if($application->admin_remarks)
                    <div class="alert alert-info mb-0">
                        <h6 class="fw-bold mb-1"><i class="bi bi-chat-left-text me-1"></i> Admin Remarks:</h6>
                        <p class="mb-0 small">{{ $application->admin_remarks }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Update & Payment Info Sidebar -->
    <div class="col-12 col-lg-4">
        <!-- Update Status Form -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i>Update Application Status</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.applications.status', $application) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_review" {{ $application->status == 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ $application->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="admin_remarks" class="form-label">Admin Remarks / Instructions</label>
                        <textarea name="admin_remarks" id="admin_remarks" rows="4" class="form-control @error('admin_remarks') is-invalid @enderror" placeholder="Provide notes or reasons for status change visible to the applicant">{{ old('admin_remarks', $application->admin_remarks) }}</textarea>
                        @error('admin_remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save me-1"></i> Update Status</button>
                </form>
            </div>
        </div>

        <!-- Payment Info Card -->
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-credit-card me-2 text-primary"></i>Payment Details</h6>
            </div>
            <div class="card-body">
                @if($application->payment)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Amount Paid:</span>
                        <span class="fw-bold text-success">रु. {{ number_format($application->payment->amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Method:</span>
                        <span class="fw-semibold text-uppercase">{{ $application->payment->payment_method }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Transaction ID:</span>
                        <span class="fw-mono small">{{ $application->payment->transaction_id ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Paid Date:</span>
                        <span class="small">{{ $application->payment->paid_at ? $application->payment->paid_at->format('M d, Y') : 'N/A' }}</span>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-exclamation-circle text-warning fs-3 mb-2 d-block"></i>
                        <span class="text-muted small">No payment record found.</span>
                        @if(($application->service->fee ?? 0) > 0)
                            <div class="mt-2 fw-bold text-dark">Fee Due: रु. {{ number_format($application->service->fee, 2) }}</div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
