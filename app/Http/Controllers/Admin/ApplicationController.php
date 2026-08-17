<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Service;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with(['user', 'service.department', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('application_number', 'like', "%{$search}%")
                  ->orWhere('applicant_name', 'like', "%{$search}%")
                  ->orWhere('applicant_email', 'like', "%{$search}%");
            });
        }

        $applications = $query->latest()->paginate(12);
        $services = Service::where('status', true)->get();

        return view('admin.applications.index', compact('applications', 'services'));
    }

    public function show(Application $application)
    {
        $application->load(['user', 'service.department', 'documents', 'payment']);
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected,completed',
            'admin_remarks' => 'nullable|string|max:1000',
        ]);

        $data = [
            'status' => $validated['status'],
            'admin_remarks' => $validated['admin_remarks'],
        ];

        if (in_array($validated['status'], ['approved', 'rejected', 'completed'])) {
            $data['processed_at'] = now();
        }

        $application->update($data);

        return redirect()->route('admin.applications.show', $application)
            ->with('success', 'Application status updated to ' . $application->getStatusLabel());
    }
}
