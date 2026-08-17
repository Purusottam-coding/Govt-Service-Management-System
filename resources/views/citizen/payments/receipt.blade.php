@extends('layouts.citizen', ['pageTitle' => 'Official Payment Receipt'])

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center no-print">
    <a href="{{ route('citizen.applications.show', $application) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Application
    </a>
    <button onclick="window.print()" class="btn btn-sm btn-primary">
        <i class="bi bi-printer me-1"></i> Print Receipt
    </button>
</div>

<div class="receipt shadow-sm">
    <div class="receipt-header">
        <div class="brand-icon-sm mx-auto mb-2" style="width:48px;height:48px;background:linear-gradient(135deg, var(--primary), var(--accent));border-radius:.75rem;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1.2rem;">
            <i class="bi bi-building"></i>
        </div>
        <h4 class="fw-bold mb-0">GOVERNMENT SERVICE SYSTEM</h4>
        <span class="text-muted small text-uppercase tracking-wider">Official Payment Receipt</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6">
            <span class="text-muted extra-small d-block">RECEIPT NUMBER</span>
            <span class="fw-bold text-dark">{{ $application->payment->transaction_id }}</span>
        </div>
        <div class="col-6 text-end">
            <span class="text-muted extra-small d-block">DATE & TIME</span>
            <span class="fw-bold text-dark">{{ $application->payment->paid_at ? $application->payment->paid_at->format('M d, Y h:i A') : now()->format('M d, Y') }}</span>
        </div>
    </div>

    <div class="bg-light p-3 rounded mb-4">
        <div class="row g-2 small">
            <div class="col-6 text-muted">Applicant Name:</div>
            <div class="col-6 text-end fw-bold text-dark">{{ $application->applicant_name }}</div>

            <div class="col-6 text-muted">Application Number:</div>
            <div class="col-6 text-end fw-bold text-primary">{{ $application->application_number }}</div>

            <div class="col-6 text-muted">Service Requested:</div>
            <div class="col-6 text-end fw-semibold text-dark">{{ $application->service->name }}</div>

            <div class="col-6 text-muted">Department:</div>
            <div class="col-6 text-end fw-semibold text-dark">{{ $application->service->department->name ?? 'Gov Dept' }}</div>

            <div class="col-6 text-muted">Payment Method:</div>
            <div class="col-6 text-end fw-semibold text-uppercase">{{ $application->payment->payment_method }}</div>
        </div>
    </div>

    <table class="table table-bordered mb-4">
        <thead>
            <tr class="table-light">
                <th>Description</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Government Processing Fee ({{ $application->service->name }})</td>
                <td class="text-end fw-bold">${{ number_format($application->payment->amount, 2) }}</td>
            </tr>
            <tr class="fw-bold">
                <td class="text-end">TOTAL PAID:</td>
                <td class="text-end text-success fs-5">${{ number_format($application->payment->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="text-center text-muted extra-small border-top pt-3">
        This is a computer-generated receipt and requires no physical signature.<br>
        Thank you for utilizing Online Government Services.
    </div>
</div>
@endsection
