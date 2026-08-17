@extends('layouts.admin', ['pageTitle' => 'Registered Citizens'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 font-weight-bold">Citizen Management</h5>
        <span class="text-muted small">View registered citizens and their application histories</span>
    </div>
</div>

<!-- Search -->
<div class="card mb-4 p-3 bg-light border-0 shadow-sm">
    <form action="{{ route('admin.citizens.index') }}" method="GET" class="row g-2">
        <div class="col-12 col-md-9">
            <input type="text" name="search" class="form-control" placeholder="Search by citizen name, email, or phone..." value="{{ request('search') }}">
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-search"></i> Search</button>
            @if(request()->filled('search'))
                <a href="{{ route('admin.citizens.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-x-lg"></i></a>
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
                    <th>Citizen Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registered Date</th>
                    <th>Applications</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($citizens as $citizen)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar" style="width:32px;height:32px;font-size:.8rem;">
                                    {{ strtoupper(substr($citizen->name, 0, 1)) }}
                                </div>
                                <span class="fw-bold text-dark">{{ $citizen->name }}</span>
                            </div>
                        </td>
                        <td>{{ $citizen->email }}</td>
                        <td>{{ $citizen->phone ?? 'N/A' }}</td>
                        <td>{{ $citizen->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold">
                                {{ $citizen->applications_count }} applications
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.citizens.show', $citizen) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i> View Profile
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No citizens found matching search.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($citizens->hasPages())
        <div class="card-footer bg-white">
            {{ $citizens->links() }}
        </div>
    @endif
</div>
@endsection
