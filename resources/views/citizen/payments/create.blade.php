@extends('layouts.citizen', ['pageTitle' => 'सरकारी सेवा दस्तुर भुक्तानी'])

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i data-lucide="credit-card" class="me-2 text-primary"></i>सरकारी सेवा आवेदन भुक्तानी</h6>
            </div>
            <div class="card-body p-4">
                <!-- Payment Summary Box -->
                <div class="bg-light p-3 rounded mb-4 border">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">निवेदन नम्बर:</span>
                        <span class="fw-bold text-primary">{{ $application->application_number }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">सेवाको नाम:</span>
                        <span class="fw-semibold text-dark">{{ $application->service->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-2 mt-2">
                        <span class="fw-bold text-dark">कुल बुझाउनुपर्ने दस्तुर:</span>
                        <span class="fw-bold text-success fs-5">रु. {{ number_format($application->service->fee, 2) }}</span>
                    </div>
                </div>

                <form action="{{ route('citizen.payments.store', $application) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="payment_method" class="form-label fw-bold">भुक्तानीको माध्यम छान्नुहोस् <span class="text-danger">*</span></label>
                        <select name="payment_method" id="payment_method" class="form-select form-select-lg @error('payment_method') is-invalid @enderror" required>
                            <option value="online" selected>eSewa / Khalti / Mobile Banking (डिजिटल वालेट)</option>
                            <option value="bank_transfer">बैंक भौचर / ट्रान्सफर</option>
                            <option value="cash">सरकारी काउन्टर (नगद)</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Secure Payment Info Notice -->
                    <div class="alert alert-info d-flex align-items-center gap-2 mb-4 py-2 small">
                        <i data-lucide="shield-check" class="text-info flex-shrink-0" style="width:20px;height:20px;"></i>
                        <div>अनलाइन भुक्तानी छनोट गर्दा तपाईंलाई सुरक्षित भुक्तानी गेटवे (eSewa / Khalti) मा पठाइनेछ।</div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                        <i data-lucide="lock" class="me-1"></i> रु. {{ number_format($application->service->fee, 2) }} भुक्तानी गर्नुहोस्
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
