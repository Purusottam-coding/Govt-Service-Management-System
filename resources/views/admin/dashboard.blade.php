@extends('layouts.admin', ['pageTitle' => 'प्रशासकीय ड्यासबोर्ड'])

@section('content')
<!-- Admin Welcome Banner -->
<div class="card bg-dark text-white mb-4 border-0 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #1e293b 100%);">
    <div class="card-body p-4 position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-bold text-uppercase small">प्रशासकीय कक्ष</span>
                    <span class="text-white-50 extra-small"><i data-lucide="calendar" class="me-1"></i>{{ date('F d, Y') }}</span>
                </div>
                <h3 class="fw-extrabold text-white mb-1">स्वागत छ, {{ auth()->user()->name }}!</h3>
                <p class="text-white-50 mb-0">नेपाल सरकार अनलाइन सेवा व्यवस्थापन प्रणाली — प्राप्त निवेदनहरू, नागरिक सूची तथा सेवाहरूको स्थिति ट्र्याक गर्नुहोस्।</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.applications.index') }}" class="btn btn-primary fw-bold px-4 py-2">
                    <i data-lucide="file-text" class="me-1"></i> निवेदनहरू समीक्षा गर्नुहोस्
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Primary Stat Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($stats['total_applications']) }}</div>
                    <div class="stat-label">कुल निवेदनहरू</div>
                </div>
                <div class="stat-icon primary"><i data-lucide="file-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($stats['pending_applications']) }}</div>
                    <div class="stat-label">छानबिन बाँकी (पेन्डिङ)</div>
                </div>
                <div class="stat-icon warning"><i data-lucide="history"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($stats['approved_applications']) }}</div>
                    <div class="stat-label">स्वीकृत निवेदनहरू</div>
                </div>
                <div class="stat-icon success"><i data-lucide="check-circle-2"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($stats['total_citizens']) }}</div>
                    <div class="stat-label">दर्ता नागरिकहरू</div>
                </div>
                <div class="stat-icon info"><i data-lucide="users"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Metric Badges Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm bg-white d-flex flex-row align-items-center gap-3">
            <div class="rounded-circle p-3 bg-primary-subtle text-primary">
                <i data-lucide="building-2"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0 text-dark">{{ $stats['total_departments'] }}</h4>
                <span class="text-muted extra-small font-weight-semibold">मन्त्रालय / विभाग</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm bg-white d-flex flex-row align-items-center gap-3">
            <div class="rounded-circle p-3 bg-success-subtle text-success">
                <i data-lucide="settings"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0 text-dark">{{ $stats['total_services'] }}</h4>
                <span class="text-muted extra-small font-weight-semibold">सक्रिय सेवाहरू</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm bg-white d-flex flex-row align-items-center gap-3">
            <div class="rounded-circle p-3 bg-info-subtle text-info" style="color:#0ea5e9;background:#e0f2fe;">
                <i data-lucide="award"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0 text-dark">{{ $stats['completed_applications'] }}</h4>
                <span class="text-muted extra-small font-weight-semibold">सम्पन्न कार्यहरू</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm bg-white d-flex flex-row align-items-center gap-3">
            <div class="rounded-circle p-3 bg-danger-subtle text-danger">
                <i data-lucide="message-square"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0 text-dark">{{ $stats['pending_feedback'] }}</h4>
                <span class="text-muted extra-small font-weight-semibold">बाँकी गुनासोहरू</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Applications Table -->
    <div class="col-12 col-xl-8">
        <div class="card table-card h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark"><i data-lucide="file-text" class="me-2 text-primary"></i>हालैका प्राप्त निवेदनहरू</span>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-primary fw-semibold">सबै हेर्नुहोस्</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>निवेदन नं.</th>
                            <th>निवेदक</th>
                            <th>सेवाको नाम</th>
                            <th>स्थिति</th>
                            <th>पेश मिति</th>
                            <th>कार्य</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentApplications as $app)
                            <tr>
                                <td class="fw-bold text-primary">{{ $app->application_number }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $app->applicant_name }}</div>
                                    <div class="extra-small text-muted">{{ $app->applicant_email }}</div>
                                </td>
                                <td><span class="fw-semibold text-dark">{{ $app->service->name ?? 'N/A' }}</span></td>
                                <td>
                                    <span class="badge-status {{ $app->getStatusBadgeClass() }}">
                                        {{ $app->getStatusLabel() }}
                                    </span>
                                </td>
                                <td><span class="small text-muted">{{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : $app->created_at->format('M d, Y') }}</span></td>
                                <td>
                                    <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-sm btn-action btn-outline-primary">
                                        <i data-lucide="eye"></i> हेर्नुहोस्
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">हालसम्म कुनै पनि निवेदन प्राप्त भएको छैन।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white py-2.5 px-3 d-flex justify-content-between align-items-center border-top">
                <span class="small text-muted fw-medium">हालैका {{ count($recentApplications) }} वटा निवेदनहरू</span>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-primary fw-semibold">
                    सबै प्राप्त निवेदनहरू व्यवस्थापन <i data-lucide="arrow-right" class="ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Feedback Widget -->
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark"><i data-lucide="message-square" class="me-2 text-primary"></i>नागरिक गुनासो / सुझाव</span>
                <a href="{{ route('admin.feedback.index') }}" class="btn btn-sm btn-outline-primary fw-semibold">सबै हेर्नुहोस्</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentFeedback as $fb)
                        <a href="{{ route('admin.feedback.show', $fb) }}" class="list-group-item list-group-item-action p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0 fw-semibold text-dark">{{ $fb->subject }}</h6>
                                <span class="badge-status {{ $fb->getStatusBadgeClass() }}">
                                    {{ $fb->status == 'open' ? 'दर्ता भएको' : ($fb->status == 'replied' ? 'जवाफ प्राप्त' : 'बन्द गरिएको') }}
                                </span>
                            </div>
                            <p class="small text-muted mb-1 text-truncate">{{ $fb->message }}</p>
                            <div class="extra-small text-secondary fw-medium"><i data-lucide="user" class="me-1"></i>निवेदक: {{ $fb->user->name ?? 'नागरिक' }}</div>
                        </a>
                    @empty
                        <div class="p-4 text-center text-muted">कुनै पनि गुनासो प्राप्त भएको छैन।</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection