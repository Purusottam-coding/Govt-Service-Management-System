@extends('layouts.citizen', ['pageTitle' => 'Complete Application Payment'])

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-credit-card me-2 text-primary"></i>Service Application Payment</h6>
            </div>
            <div class="card-body p-4">
                <!-- Payment Summary Box -->
                <div class="bg-light p-3 rounded mb-4 border">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Application Number:</span>
                        <span class="fw-bold text-primary">{{ $application->application_number }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Service Name:</span>
                        <span class="fw-semibold text-dark">{{ $application->service->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-2 mt-2">
                        <span class="fw-bold text-dark">Total Fee Payable:</span>
                        <span class="fw-bold text-success fs-5">${{ number_format($application->service->fee, 2) }}</span>
                    </div>
                </div>

                <form action="{{ route('citizen.payments.store', $application) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="payment_method" class="form-label fw-bold">Select Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required onchange="togglePaymentFields(this)">
                            <option value="online">Debit / Credit Card (Simulated Online)</option>
                            <option value="cash">Government Counter / Cash</option>
                            <option value="bank_transfer">Direct Bank Wire Transfer</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Online Card Fields -->
                    <div id="cardFields" class="mb-4">
                        <div class="mb-3">
                            <label for="card_number" class="form-label">Card Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                                <input type="text" class="form-control" id="card_number" name="card_number" placeholder="4532 •••• •••• 8892" value="4532 1111 2222 8892">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="exp" class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="exp" placeholder="MM/YY" value="12/28">
                            </div>
                            <div class="col-6">
                                <label for="cvv" class="form-label">CVV / CVC</label>
                                <input type="text" class="form-control" id="cvv" placeholder="123" value="789">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                        <i class="bi bi-lock me-1"></i> Pay ${{ number_format($application->service->fee, 2) }} Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePaymentFields(select) {
        const cardFields = document.getElementById('cardFields');
        if (select.value === 'online') {
            cardFields.classList.remove('d-none');
        } else {
            cardFields.classList.add('d-none');
        }
    }
</script>
@endpush
@endsection
