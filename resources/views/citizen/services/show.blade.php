@extends('layouts.citizen', ['pageTitle' => $service->name])

@section('content')
<div class="mb-4">
    <a href="{{ route('citizen.services.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Services Directory
    </a>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <div class="card-body p-4">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold mb-2">
                    {{ $service->department->name ?? 'Government Service' }}
                </span>
                <h3 class="fw-bold mb-3">{{ $service->name }}</h3>

                <p class="text-secondary leading-relaxed mb-4">{{ $service->description ?? 'No detailed description provided for this service.' }}</p>

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Required Documents for Application</h6>
                @if(!empty($service->required_documents) && is_array($service->required_documents))
                    <ul class="list-group mb-4">
                        @foreach($service->required_documents as $doc)
                            <li class="list-group-item d-flex align-items-center gap-2 py-3">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <div>
                                    <span class="fw-semibold text-dark d-block">{{ $doc }}</span>
                                    <span class="text-muted extra-small">Please prepare scanned copy (PDF, JPG, PNG)</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-light border mb-4">No special documents required for this service.</div>
                @endif

                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="{{ route('citizen.applications.create', ['service_id' => $service->id]) }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-send me-2"></i> Apply for this Service Online
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i>Service Summary</h6>
            </div>
            <div class="card-body">
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted small d-block">Department</span>
                    <span class="fw-bold text-dark">{{ $service->department->name ?? 'N/A' }}</span>
                </div>
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted small d-block">Service Fee</span>
                    <span class="fw-bold text-success fs-5">{{ $service->fee > 0 ? '$' . number_format($service->fee, 2) : 'Free of Charge' }}</span>
                </div>
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted small d-block">Processing Time</span>
                    <span class="fw-semibold text-dark"><i class="bi bi-clock me-1 text-muted"></i>Estimated {{ $service->processing_days }} Business Days</span>
                </div>
                <div class="mb-0">
                    <span class="text-muted small d-block">Department Contact</span>
                    <span class="small d-block"><i class="bi bi-telephone me-1 text-muted"></i>{{ $service->department->phone ?? 'N/A' }}</span>
                    <span class="small d-block"><i class="bi bi-envelope me-1 text-muted"></i>{{ $service->department->email ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
