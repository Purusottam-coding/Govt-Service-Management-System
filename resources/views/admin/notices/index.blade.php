@extends('layouts.admin', ['pageTitle' => 'Manage Notices'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 font-weight-bold">Public Notices & Announcements</h5>
        <span class="text-muted small">Publish announcements displayed on the public landing page</span>
    </div>
    <a href="{{ route('admin.notices.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Notice
    </a>
</div>

<div class="card table-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Published Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notices as $notice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $notice->title }}</div>
                            <div class="small text-muted text-truncate" style="max-width:400px;">{{ Str::limit($notice->content, 100) }}</div>
                        </td>
                        <td>
                            <div class="small"><i class="bi bi-calendar-event me-1 text-muted"></i>{{ $notice->published_at ? $notice->published_at->format('M d, Y') : 'Draft' }}</div>
                        </td>
                        <td>
                            @if($notice->is_active)
                                <span class="badge-status badge-active">Published</span>
                            @else
                                <span class="badge-status badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.notices.edit', $notice) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('Delete this notice?');" class="d-inline">
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
                        <td colspan="5" class="text-center py-4 text-muted">No notices published yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($notices->hasPages())
        <div class="card-footer bg-white">
            {{ $notices->links() }}
        </div>
    @endif
</div>
@endsection
