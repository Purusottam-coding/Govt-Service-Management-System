@extends('layouts.citizen', ['pageTitle' => 'Submit Feedback'])

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-chat-dots me-2 text-primary"></i>Submit Feedback or Query</h6>
                <a href="{{ route('citizen.feedback.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('citizen.feedback.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="service_id" class="form-label">Related Service (Optional)</label>
                        <select name="service_id" id="service_id" class="form-select @error('service_id') is-invalid @enderror">
                            <option value="">General Inquiry / Feedback</option>
                            @foreach($services as $srv)
                                <option value="{{ $srv->id }}" {{ old('service_id') == $srv->id ? 'selected' : '' }}>
                                    {{ $srv->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required placeholder="Brief summary of your query or suggestion">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label">Message / Details <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required placeholder="Describe your question, issue, or feedback in detail...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('citizen.feedback.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-send me-1"></i> Send Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
