@extends('layouts.admin', ['pageTitle' => 'Citizen Profile'])

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.citizens.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Citizens
    </a>
</div>

<div class="row g-4">
    <!-- Citizen Profile Card -->
    <div class="col-12 col-lg-4">
        <div class="card text-center p-4">
            <div class="user-avatar mx-auto mb-3" style="width:72px;height:72px;font-size:1.75rem;">
                {{ strtoupper(substr($citizen->name, 0, 1)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $citizen->name }}</h5>
            <span class="badge bg-secondary mb-3">Citizen</span>

            <div class="text-start mt-3">
                <div class="mb-2"><i class="bi bi-envelope me-2 text-muted"></i><strong>Email:</strong> {{ $citizen->email }}</div>
                <div class="mb-2"><i class="bi bi-telephone me-2 text-muted"></i><strong>Phone:</strong> {{ $citizen->phone ?? 'N/A' }}</div>
                <div class="mb-2"><i class="bi bi-geo-alt me-2 text-muted"></i><strong>Address:</strong> {{ $citizen->address ?? 'N/A' }}</div>
                <div class="mb-0"><i class="bi bi-calendar3 me-2 text-muted"></i><strong>Registered:</strong> {{ $citizen->created_at->format('M d, Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Application History -->
    <div class="col-12 col-lg-8">
        <div class="card table-card h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Application History</h6>
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
                        @forelse($citizen->applications as $app)
                            <tr>
                                <td class="fw-bold text-primary">{{ $app->application_number }}</td>
                                <td>{{ $app->service->name ?? 'N/A' }}</td>
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
                                <td colspan="5" class="text-center py-4 text-muted">No applications submitted by this citizen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
