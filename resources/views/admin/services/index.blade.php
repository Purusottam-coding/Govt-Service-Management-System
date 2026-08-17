@extends('layouts.admin', ['pageTitle' => 'Manage Government Services'])

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h5 class="mb-1 font-weight-bold">Government Services</h5>
        <span class="text-muted small">Manage available public services, fees, and requirements</span>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add New Service
    </a>
</div>

<!-- Filters -->
<div class="card mb-4 p-3 bg-light border-0 shadow-sm">
    <form action="{{ route('admin.services.index') }}" method="GET" class="row g-2">
        <div class="col-12 col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Search by service name..." value="{{ request('search') }}">
        </div>
        <div class="col-12 col-md-4">
            <select name="department_id" class="form-select">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-search me-1"></i> Filter</button>
            @if(request()->hasAny(['search', 'department_id']))
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-x-lg"></i></a>
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
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Department</th>
                    <th>Fee</th>
                    <th>Processing Time</th>
                    <th>Applications</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('admin.services.show', $service) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $service->name }}
                            </a>
                            @if(!empty($service->required_documents))
                                <div class="small text-muted"><i class="bi bi-paperclip me-1"></i>{{ count($service->required_documents) }} docs required</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $service->department->name ?? 'Unassigned' }}</span>
                        </td>
                        <td class="fw-bold text-success">
                            ${{ number_format($service->fee, 2) }}
                        </td>
                        <td>
                            <span class="small"><i class="bi bi-clock me-1 text-muted"></i>{{ $service->processing_days }} Days</span>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $service->applications_count }}</span>
                        </td>
                        <td>
                            @if($service->status)
                                <span class="badge-status badge-active">Active</span>
                            @else
                                <span class="badge-status badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.services.show', $service) }}" class="btn btn-outline-primary" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No services found matching criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($services->hasPages())
        <div class="card-footer bg-white">
            {{ $services->links() }}
        </div>
    @endif
</div>
@endsection
