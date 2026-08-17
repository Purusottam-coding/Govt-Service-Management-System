@extends('layouts.admin', ['pageTitle' => 'Citizen Feedback'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 font-weight-bold">Feedback & Inquiries</h5>
        <span class="text-muted small">Review citizen feedback and provide official responses</span>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4 p-3 bg-light border-0 shadow-sm">
    <form action="{{ route('admin.feedback.index') }}" method="GET" class="row g-2">
        <div class="col-12 col-md-9">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open / Pending Reply</option>
                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-filter"></i> Filter</button>
            @if(request()->filled('status'))
                <a href="{{ route('admin.feedback.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-x-lg"></i></a>
            @endif
        </div>
    </form>
</div>

<div class="card table-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Citizen</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedbackList as $fb)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $fb->subject }}</div>
                            <div class="small text-muted text-truncate" style="max-width:300px;">{{ Str::limit($fb->message, 80) }}</div>
                        </td>
                        <td>
                            <div class="fw-medium">{{ $fb->user->name ?? 'Citizen' }}</div>
                            <div class="small text-muted">{{ $fb->user->email ?? '' }}</div>
                        </td>
                        <td>{{ $fb->service->name ?? 'General Inquiry' }}</td>
                        <td><span class="badge-status {{ $fb->getStatusBadgeClass() }}">{{ ucfirst($fb->status) }}</span></td>
                        <td>{{ $fb->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.feedback.show', $fb) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-reply me-1"></i> Review & Reply
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No feedback messages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($feedbackList->hasPages())
        <div class="card-footer bg-white">
            {{ $feedbackList->links() }}
        </div>
    @endif
</div>
@endsection
