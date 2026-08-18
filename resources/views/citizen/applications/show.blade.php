@extends('layouts.citizen', ['pageTitle' => 'निवेदन विवरण तथा स्थिति'])

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('citizen.applications.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> मेरा निवेदनहरूमा फर्कनुहोस्
    </a>
    @if($application->payment)
        <a href="{{ route('citizen.payments.receipt', $application) }}" class="btn btn-sm btn-outline-success">
            <i class="bi bi-receipt me-1"></i> भुक्तानी रसिद हेर्नुहोस्
        </a>
    @elseif(($application->service->fee ?? 0) > 0)
        <a href="{{ route('citizen.payments.create', $application) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-credit-card me-1"></i> दस्तुर भुक्तानी गर्नुहोस् (रु. {{ number_format($application->service->fee, 2) }})
        </a>
    @endif
</div>

<!-- Visual Status Tracker -->
<div class="card mb-4 p-4 bg-white">
    <h6 class="fw-bold text-center mb-3">निवेदन प्रगति स्थिति</h6>

    <ul class="status-tracker">
        <li class="step {{ in_array($application->status, ['pending', 'under_review', 'approved', 'completed']) ? 'completed' : '' }}">
            <div class="step-icon"><i class="bi bi-send-check"></i></div>
            <div class="step-label">पेश गरिएको</div>
        </li>
        <li class="step {{ in_array($application->status, ['under_review', 'approved', 'completed']) ? 'completed' : ($application->status == 'pending' ? 'active' : '') }}">
            <div class="step-icon"><i class="bi bi-search"></i></div>
            <div class="step-label">छानबिनमा</div>
        </li>
        @if($application->status == 'rejected')
            <li class="step rejected">
                <div class="step-icon"><i class="bi bi-x-circle"></i></div>
                <div class="step-label">अस्वीकृत</div>
            </li>
        @else
            <li class="step {{ in_array($application->status, ['approved', 'completed']) ? 'completed' : '' }}">
                <div class="step-icon"><i class="bi bi-check-lg"></i></div>
                <div class="step-label">स्वीकृत</div>
            </li>
            <li class="step {{ $application->status == 'completed' ? 'completed' : '' }}">
                <div class="step-icon"><i class="bi bi-award"></i></div>
                <div class="step-label">सम्पन्न</div>
            </li>
        @endif
    </ul>
</div>

<div class="row g-4">
    <!-- Main Info -->
    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2 text-primary"></i>निवेदन नं. #{{ $application->application_number }}</h6>
                <span class="badge-status {{ $application->getStatusBadgeClass() }}">{{ $application->getStatusLabel() }}</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-4">
                        <span class="text-muted small d-block">सेवाको नाम</span>
                        <span class="fw-bold text-dark">{{ $application->service->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="text-muted small d-block">मन्त्रालय / विभाग</span>
                        <span class="fw-semibold">{{ $application->service->department->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="text-muted small d-block">पेश गरेको मिति</span>
                        <span class="fw-semibold">{{ $application->submitted_at ? $application->submitted_at->format('M d, Y h:i A') : $application->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                @if($application->admin_remarks)
                    <div class="alert alert-info mb-4">
                        <h6 class="fw-bold mb-1"><i class="bi bi-info-circle me-1"></i> प्रशासकीय टिप्पणी / सूचना:</h6>
                        <p class="mb-0 small" style="white-space: pre-line;">{{ $application->admin_remarks }}</p>
                    </div>
                @endif

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-file-earmark-check me-2 text-primary"></i>अपलोड गरिएका कागजातहरू</h6>
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
                                    <i class="bi bi-eye"></i> हेर्नुहोस्
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-3 bg-light rounded text-muted small mb-4">यस निवेदनको लागि कुनै पनि कागजात अपलोड गरिएको छैन।</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Summary Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-credit-card me-2 text-primary"></i>भुक्तानी तथा दस्तुर</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">आवश्यक दस्तुर:</span>
                    <span class="fw-bold text-dark">रु. {{ number_format($application->service->fee ?? 0, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">भुक्तानी स्थिति:</span>
                    @if($application->payment)
                        <span class="badge bg-success">चुक्ता भएको</span>
                    @elseif(($application->service->fee ?? 0) > 0)
                        <span class="badge bg-warning text-dark">बाँकी (बाँकी भुक्तानी)</span>
                    @else
                        <span class="badge bg-light text-muted">निःशुल्क</span>
                    @endif
                </div>

                @if(!$application->payment && ($application->service->fee ?? 0) > 0)
                    <a href="{{ route('citizen.payments.create', $application) }}" class="btn btn-warning w-100 fw-bold">
                        <i class="bi bi-credit-card me-1"></i> भुक्तानी गर्नुहोस्
                    </a>
                @endif

                @if($application->payment)
                    <hr>
                    <div class="small">
                        <div><strong>कारोबार नं (Transaction ID):</strong> {{ $application->payment->transaction_id }}</div>
                        <div><strong>भुक्तानी मिति:</strong> {{ $application->payment->paid_at ? $application->payment->paid_at->format('M d, Y') : '' }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
