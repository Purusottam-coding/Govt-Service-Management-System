@extends('layouts.admin', ['pageTitle' => 'निवेदन समीक्षा'])

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> निवेदन सूचीमा फर्कनुहोस्
    </a>
</div>

<div class="row g-4">
    <!-- Application Details & Documents -->
    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-file-earmark-person me-2 text-primary"></i>निवेदन नं. #{{ $application->application_number }}</h6>
                <span class="badge-status {{ $application->getStatusBadgeClass() }}">{{ $application->getStatusLabel() }}</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <span class="text-muted small d-block">अनुरोध गरिएको सेवा</span>
                        <span class="fw-bold text-dark">{{ $application->service->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <span class="text-muted small d-block">मन्त्रालय / विभाग</span>
                        <span class="fw-semibold">{{ $application->service->department->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <span class="text-muted small d-block">पेश गरेको मिति</span>
                        <span class="fw-semibold">{{ $application->submitted_at ? $application->submitted_at->format('M d, Y h:i A') : $application->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <span class="text-muted small d-block">प्रशोधन मिति</span>
                        <span class="fw-semibold">{{ $application->processed_at ? $application->processed_at->format('M d, Y') : 'अझै प्रशोधन भएको छैन' }}</span>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person me-2 text-primary"></i>निवेदकको विवरण</h6>
                <div class="row g-3 mb-4 bg-light p-3 rounded">
                    <div class="col-md-6">
                        <span class="text-muted small d-block">पूरा नाम</span>
                        <span class="fw-semibold text-dark">{{ $application->applicant_name }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block">इमेल ठेगाना</span>
                        <span class="fw-semibold text-dark">{{ $application->applicant_email }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block">फोन नम्बर</span>
                        <span class="fw-semibold text-dark">{{ $application->applicant_phone ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block">ठेगाना</span>
                        <span class="fw-semibold text-dark">{{ $application->applicant_address ?? 'N/A' }}</span>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-file-earmark-check me-2 text-primary"></i>अपलोड गरिएका कागजातहरू</h6>
                @if($application->documents->count() > 0)
                    <div class="row g-2 mb-4">
                        @foreach($application->documents as $doc)
                            <div class="col-12 col-md-6">
                                <div class="p-3 border rounded d-flex justify-content-between align-items-center bg-white">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-pdf fs-4 text-danger"></i>
                                        <div>
                                            <div class="fw-semibold small">{{ $doc->document_name }}</div>
                                            <span class="text-muted extra-small">अपलोड गरिएको</span>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> हेर्नुहोस्
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-3 bg-light rounded text-muted small mb-4">यस निवेदनको लागि कुनै पनि कागजात अपलोड गरिएको छैन।</div>
                @endif

                @if($application->admin_remarks)
                    <div class="alert alert-info mb-0">
                        <h6 class="fw-bold mb-1"><i class="bi bi-chat-left-text me-1"></i> प्रशासकीय टिप्पणी:</h6>
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
                <h6 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i>निवेदन स्थिति अद्यावधिक</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.applications.status', $application) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="status" class="form-label">स्थिति <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>पेश गरिएको (पेन्डिङ)</option>
                            <option value="under_review" {{ $application->status == 'under_review' ? 'selected' : '' }}>छानबिनमा</option>
                            <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>स्वीकृत</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>अस्वीकृत</option>
                            <option value="completed" {{ $application->status == 'completed' ? 'selected' : '' }}>सम्पन्न</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="admin_remarks" class="form-label">प्रशासकीय टिप्पणी / निर्देशन</label>
                        <textarea name="admin_remarks" id="admin_remarks" rows="4" class="form-control @error('admin_remarks') is-invalid @enderror" placeholder="स्थिति परिवर्तनको कारण वा निर्देशन लेख्नुहोस् — निवेदकले देख्न सक्नुहुनेछ">{{ old('admin_remarks', $application->admin_remarks) }}</textarea>
                        @error('admin_remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save me-1"></i> स्थिति अद्यावधिक गर्नुहोस्</button>
                </form>
            </div>
        </div>

        <!-- Payment Info Card -->
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-credit-card me-2 text-primary"></i>भुक्तानी विवरण</h6>
            </div>
            <div class="card-body">
                @if($application->payment)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">चुक्ता रकम:</span>
                        <span class="fw-bold text-success">रु. {{ number_format($application->payment->amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">भुक्तानी माध्यम:</span>
                        <span class="fw-semibold text-uppercase">{{ $application->payment->payment_method }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">कारोबार नम्बर:</span>
                        <span class="fw-mono small">{{ $application->payment->transaction_id ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">भुक्तानी मिति:</span>
                        <span class="small">{{ $application->payment->paid_at ? $application->payment->paid_at->format('M d, Y') : 'N/A' }}</span>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-exclamation-circle text-warning fs-3 mb-2 d-block"></i>
                        <span class="text-muted small">भुक्तानीको कुनै रेकर्ड भेटिएन।</span>
                        @if(($application->service->fee ?? 0) > 0)
                            <div class="mt-2 fw-bold text-dark">बाँकी दस्तुर: रु. {{ number_format($application->service->fee, 2) }}</div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
