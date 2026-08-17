<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create(Application $application)
    {
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        if ($application->payment && $application->payment->status === 'completed') {
            return redirect()->route('citizen.payments.receipt', $application)
                ->with('info', 'Payment has already been completed for this application.');
        }

        $application->load('service');
        return view('citizen.payments.create', compact('application'));
    }

    public function store(Request $request, Application $application)
    {
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:cash,online,bank_transfer',
        ]);

        $amount = $application->service->fee;

        // Generate simulated transaction ID
        $txnId = 'TXN-' . strtoupper(Str::random(10));

        $payment = Payment::updateOrCreate(
            ['application_id' => $application->id],
            [
                'amount' => $amount,
                'payment_method' => $validated['payment_method'],
                'transaction_id' => $txnId,
                'status' => 'completed',
                'paid_at' => now(),
            ]
        );

        return redirect()->route('citizen.payments.receipt', $application)
            ->with('success', 'Payment of $' . number_format($amount, 2) . ' received successfully!');
    }

    public function receipt(Application $application)
    {
        if ($application->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $application->load(['service.department', 'payment', 'user']);

        if (!$application->payment) {
            return redirect()->route('citizen.applications.show', $application)
                ->with('error', 'No payment record found for this application.');
        }

        return view('citizen.payments.receipt', compact('application'));
    }
}
