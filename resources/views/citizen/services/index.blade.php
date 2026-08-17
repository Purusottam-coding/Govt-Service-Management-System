@extends('layouts.citizen', ['pageTitle' => 'Government Services'])

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Government Services Directory</h4>
        <span class="text-muted small">Explore available public services, check eligibility, fee details, and apply online</span>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="card mb-4 p-3 bg-white border-0 shadow-sm">
    <form action="{{ route('citizen.services.index') }}" method="GET" class="row g-2">
        <div class="col-12 col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search service by name or keyword..." value="{{ request('search') }}">
            </div>
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
        <div class="col-12 col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
            @if(request()->hasAny(['search', 'department_id']))
                <a href="{{ route('citizen.services.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-x-lg"></i></a>
            @endif
        </div>
    </form>
</div>

<!-- Service Cards Grid -->
<div class="row g-4 mb-4">
    @forelse($services as $service)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="service-card">
                <span class="service-dept">{{ $service->department->name ?? 'Government Service' }}</span>
                <h5 class="fw-bold mb-2 text-dark">{{ $service->name }}</h5>
                <p class="small text-muted mb-3 flex-grow-1">{{ Str::limit($service->description, 100) }}</p>

                <div class="mb-3 small text-secondary">
                    <div><i class="bi bi-clock me-1"></i><strong>Processing:</strong> {{ $service->processing_days }} Days</div>
                    @if(!empty($service->required_documents))
                        <div><i class="bi bi-paperclip me-1"></i><strong>Required Docs:</strong> {{ count($service->required_documents) }}</div>
                    @endif
                </div>

                <div class="service-meta">
                    <span class="service-fee">{{ $service->fee > 0 ? '$' . number_format($service->fee, 2) : 'Free' }}</span>
                    <a href="{{ route('citizen.services.show', $service) }}" class="btn btn-sm btn-primary">
                        View & Apply <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5 bg-white rounded border">
                <i class="bi bi-search text-muted fs-1 mb-2 d-block"></i>
                <h6 class="fw-bold text-muted">No government services found.</h6>
                <p class="small text-muted">Try adjusting your search criteria or filter options.</p>
            </div>
        </div>
    @endforelse
</div>

@if($services->hasPages())
    <div class="d-flex justify-content-center">
        {{ $services->links() }}
    </div>
@endif
@endsection
