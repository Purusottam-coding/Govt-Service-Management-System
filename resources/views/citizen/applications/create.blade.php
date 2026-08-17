@extends('layouts.citizen', ['pageTitle' => 'Apply for Government Service'])

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-plus me-2 text-primary"></i>Online Service Application</h5>
                <a href="{{ route('citizen.services.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('citizen.applications.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Select Service -->
                    <div class="mb-4">
                        <label for="service_id" class="form-label fw-bold">Select Government Service <span class="text-danger">*</span></label>
                        <select name="service_id" id="service_id" class="form-select form-select-lg @error('service_id') is-invalid @enderror" required onchange="updateServiceInfo(this)">
                            <option value="">-- Select Service --</option>
                            @foreach($services as $srv)
                                <option value="{{ $srv->id }}"
                                    data-fee="{{ $srv->fee }}"
                                    data-days="{{ $srv->processing_days }}"
                                    data-docs="{{ is_array($srv->required_documents) ? implode(', ', $srv->required_documents) : '' }}"
                                    {{ ($service && $service->id == $srv->id) || old('service_id') == $srv->id ? 'selected' : '' }}>
                                    {{ $srv->name }} ({{ $srv->department->name ?? 'Gov' }}) — {{ $srv->fee > 0 ? '$' . number_format($srv->fee, 2) : 'Free' }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dynamic Service Info Alert -->
                    <div id="serviceInfoAlert" class="alert alert-info d-none mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Estimated Processing:</strong> <span id="infoDays">-</span> days<br>
                                <strong>Service Fee:</strong> $<span id="infoFee">0.00</span>
                            </div>
                            <i class="bi bi-info-circle fs-3"></i>
                        </div>
                        <div class="mt-2 small border-top pt-2" id="infoDocsWrapper">
                            <strong>Required Documents:</strong> <span id="infoDocs">None</span>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-person me-2 text-primary"></i>Applicant Details</h6>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="applicant_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('applicant_name') is-invalid @enderror" id="applicant_name" name="applicant_name" value="{{ old('applicant_name', $user->name) }}" required>
                            @error('applicant_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="applicant_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('applicant_email') is-invalid @enderror" id="applicant_email" name="applicant_email" value="{{ old('applicant_email', $user->email) }}" required>
                            @error('applicant_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="applicant_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control @error('applicant_phone') is-invalid @enderror" id="applicant_phone" name="applicant_phone" value="{{ old('applicant_phone', $user->phone) }}" placeholder="+1 234 567 890">
                            @error('applicant_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="applicant_address" class="form-label">Residential Address</label>
                            <input type="text" class="form-control @error('applicant_address') is-invalid @enderror" id="applicant_address" name="applicant_address" value="{{ old('applicant_address', $user->address) }}" placeholder="Street, City, ZIP">
                            @error('applicant_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-cloud-upload me-2 text-primary"></i>Upload Documents</h6>

                    <div id="documentsContainer">
                        <div class="row g-2 mb-3 document-row">
                            <div class="col-md-5">
                                <input type="text" name="document_names[]" class="form-control" placeholder="Document Label (e.g. Passport Copy)">
                            </div>
                            <div class="col-md-7">
                                <input type="file" name="documents[]" class="form-control">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-secondary mb-4" onclick="addDocumentRow()">
                        <i class="bi bi-plus-circle me-1"></i> Add Another Document
                    </button>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('citizen.applications.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-send me-1"></i> Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateServiceInfo(select) {
        const option = select.options[select.selectedIndex];
        const alert = document.getElementById('serviceInfoAlert');
        if (option.value) {
            document.getElementById('infoFee').innerText = parseFloat(option.getAttribute('data-fee')).toFixed(2);
            document.getElementById('infoDays').innerText = option.getAttribute('data-days');
            const docs = option.getAttribute('data-docs');
            document.getElementById('infoDocs').innerText = docs || 'None specified';
            alert.classList.remove('d-none');
        } else {
            alert.classList.add('d-none');
        }
    }

    function addDocumentRow() {
        const container = document.getElementById('documentsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'row g-2 mb-3 document-row';
        newRow.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="document_names[]" class="form-control" placeholder="Document Label">
            </div>
            <div class="col-md-6">
                <input type="file" name="documents[]" class="form-control">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.document-row').remove()"><i class="bi bi-trash"></i></button>
            </div>
        `;
        container.appendChild(newRow);
    }

    // Trigger on load if option selected
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('service_id');
        if (select.value) updateServiceInfo(select);
    });
</script>
@endpush
@endsection
