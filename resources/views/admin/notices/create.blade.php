@extends('layouts.admin', ['pageTitle' => 'Create Notice'])

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-megaphone me-2 text-primary"></i>Create Public Notice</h6>
                <a href="{{ route('admin.notices.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.notices.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Notice Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. System Maintenance & Office Closure Notice">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6" required placeholder="Write announcement details here...">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="date" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}">
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label fw-semibold" for="is_active">Publish Immediately</label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.notices.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Save Notice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
