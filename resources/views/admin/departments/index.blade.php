@extends('layouts.admin', ['pageTitle' => 'Manage Departments'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 font-weight-bold">Government Departments</h5>
    <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Department
    </a>
</div>

<div class="card table-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Contact Info</th>
                    <th>Services Count</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $dept->name }}</div>
                            <div class="small text-muted text-truncate" style="max-width:300px;">{{ $dept->description ?? 'No description' }}</div>
                        </td>
                        <td>
                            <div class="small"><i class="bi bi-telephone me-1 text-muted"></i>{{ $dept->phone ?? 'N/A' }}</div>
                            <div class="small"><i class="bi bi-envelope me-1 text-muted"></i>{{ $dept->email ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-semibold">{{ $dept->services_count }} services</span>
                        </td>
                        <td>
                            @if($dept->status)
                                <span class="badge-status badge-active">Active</span>
                            @else
                                <span class="badge-status badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?');" class="d-inline">
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
                        <td colspan="6" class="text-center py-4 text-muted">No departments created yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($departments->hasPages())
        <div class="card-footer bg-white">
            {{ $departments->links() }}
        </div>
    @endif
</div>
@endsection
