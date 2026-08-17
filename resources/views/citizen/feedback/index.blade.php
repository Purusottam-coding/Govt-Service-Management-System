@extends('layouts.citizen', ['pageTitle' => 'My Feedback & Support'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Feedback & Support Tickets</h4>
        <span class="text-muted small">Submit suggestions, issues, or inquiries to government service admin</span>
    </div>
    <a href="{{ route('citizen.feedback.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Submit Feedback
    </a>
</div>

<div class="row g-4">
    <div class="col-12">
        @forelse($feedbackList as $fb)
            <div class="card mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $fb->subject }}</h6>
                            @if($fb->service)
                                <span class="badge bg-light text-dark border me-2">Service: {{ $fb->service->name }}</span>
                            @endif
                            <span class="text-muted extra-small"><i class="bi bi-calendar3 me-1"></i>{{ $fb->created_at->format('M d, Y') }}</span>
                        </div>
                        <span class="badge-status {{ $fb->getStatusBadgeClass() }}">{{ ucfirst($fb->status) }}</span>
                    </div>

                    <p class="text-secondary small mb-3" style="white-space: pre-line;">{{ $fb->message }}</p>

                    @if($fb->admin_reply)
                        <div class="p-3 bg-light rounded border-start border-3 border-primary">
                            <div class="fw-bold text-primary small mb-1"><i class="bi bi-reply-fill me-1"></i> Admin Response:</div>
                            <p class="mb-0 small text-dark" style="white-space: pre-line;">{{ $fb->admin_reply }}</p>
                        </div>
                    @else
                        <div class="text-muted extra-small"><i class="bi bi-clock me-1"></i>Awaiting official reply from system administrator.</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="card text-center py-5">
                <i class="bi bi-chat-left-dots text-muted fs-1 mb-2 d-block"></i>
                <h6 class="fw-bold text-muted">No feedback submitted yet.</h6>
                <p class="small text-muted mb-3">Have a question or suggestion? Feel free to reach out to us.</p>
                <div>
                    <a href="{{ route('citizen.feedback.create') }}" class="btn btn-sm btn-primary">Submit Feedback</a>
                </div>
            </div>
        @endforelse

        @if($feedbackList->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $feedbackList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
