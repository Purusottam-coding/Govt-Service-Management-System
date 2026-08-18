@extends('layouts.citizen', ['pageTitle' => 'मेरा निवेदनहरू'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">मेरा पेश गरिएका निवेदनहरू</h4>
        <span class="text-muted small">तपाईंले पेश गर्नुभएका सबै हालैका तथा पुराना सरकारी निवेदनहरू हेर्नुहोस्</span>
    </div>
    <a href="{{ route('citizen.applications.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> नयाँ निवेदन पेश गर्नुहोस्
    </a>
</div>

<!-- Filters -->
<div class="card mb-4 p-3 bg-white border-0 shadow-sm">
    <form action="{{ route('citizen.applications.index') }}" method="GET" class="row g-2">
        <div class="col-12 col-md-9">
            <select name="status" class="form-select">
                <option value="">सबै निवेदन स्थितिहरू</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>पेश गरिएको (पेन्डिङ)</option>
                <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>छानबिनमा (Under Review)</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>स्वीकृत (Approved)</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>अस्वीकृत (Rejected)</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>सम्पन्न (Completed)</option>
            </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-filter"></i> फिल्टर गर्नुहोस्</button>
            @if(request()->filled('status'))
                <a href="{{ route('citizen.applications.index') }}" class="btn btn-outline-secondary" title="पुनः सेट गर्नुहोस्"><i class="bi bi-x-lg"></i></a>
            @endif
        </div>
    </form>
</div>

<div class="card table-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>निवेदन नं.</th>
                    <th>सेवाको नाम</th>
                    <th>मन्त्रालय / विभाग</th>
                    <th>दस्तुर स्थिति</th>
                    <th>निवेदन स्थिति</th>
                    <th>पेश गरेको मिति</th>
                    <th>कार्य</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td class="fw-bold text-primary">{{ $app->application_number }}</td>
                        <td class="fw-semibold">{{ $app->service->name ?? 'N/A' }}</td>
                        <td>{{ $app->service->department->name ?? 'N/A' }}</td>
                        <td>
                            @if($app->payment)
                                <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold">चुक्ता भएको</span>
                            @elseif(($app->service->fee ?? 0) > 0)
                                <a href="{{ route('citizen.payments.create', $app) }}" class="badge bg-warning-subtle text-warning border border-warning-subtle text-decoration-none fw-semibold">
                                    भुक्तानी गर्नुहोस् (रु. {{ number_format($app->service->fee, 2) }})
                                </a>
                            @else
                                <span class="badge bg-light text-muted border">निःशुल्क</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status {{ $app->getStatusBadgeClass() }}">{{ $app->getStatusLabel() }}</span>
                        </td>
                        <td>{{ $app->submitted_at ? $app->submitted_at->format('M d, Y') : $app->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('citizen.applications.show', $app) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i> विवरण
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-2 d-block mb-2 text-muted"></i>
                            कुनै पनि निवेदन भेटिएन।<br>
                            <a href="{{ route('citizen.applications.create') }}" class="btn btn-sm btn-primary mt-2">नयाँ निवेदन पेश गर्नुहोस्</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($applications->hasPages())
        <div class="card-footer bg-white">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
