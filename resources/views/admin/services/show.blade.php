@extends('layouts.admin', ['pageTitle' => 'Service Details'])

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Services
    </a>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i>Service Information</h6>
            </div>
            <div class="card-body">
                <h5 class="fw-bold mb-2">{{ $service->name }}</h5>
                <span class="badge bg-primary mb-3">{{ $service->department->name ?? 'Unassigned' }}</span>

                <p class="text-muted small mb-4">{{ $service->description ?? 'No description provided.' }}</p>

                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Fee:</span>
                        <span class="fw-bold text-success">${{ number_format($service->fee, 2) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Processing Time:</span>
                        <span class="fw-semibold">{{ $service->processing_days }} Days</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Status:</span>
                        @if($service->status)
                            <span class="badge-status badge-active">Active</span>
                        @else
                            <span class="badge-status badge-inactive">Inactive</span>
                        @endif
                    </li>
                </ul>

                <h6 class="fw-bold fs-7 text-uppercase text-muted mt-4 mb-2">Required Documents</h6>
                @if(!empty($service->required_documents) && is_array($service->required_documents))
                    <ul class="list-group list-group-flush">
                        @foreach($service->required_documents as $doc)
                            <li class="list-group-item px-0 py-1 small">
                                <i class="bi bi-file-earmark-check text-primary me-2"></i>{{ $doc }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-muted small">No specific documents required.</span>
                @endif
            </div>
            <div class="card-footer bg-white text-end">
                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i> Edit Service
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card table-card h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Applications for this Service</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>App #</th>
                            <th>Applicant</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($service->applications as $app)
                            <tr>
                                <td class="fw-bold text-primary">{{ $app->application_number }}</td>
                                <td>{{ $app->applicant_name }}</td>
                                <td><span class="badge-status {{ $app->getStatusBadgeClass() }}">{{ $app->getStatusLabel() }}</span></td>
                                <td>{{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : $app->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No applications submitted for this service yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
