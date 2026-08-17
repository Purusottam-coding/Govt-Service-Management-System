<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'application_number',
        'applicant_name',
        'applicant_email',
        'applicant_phone',
        'applicant_address',
        'status',
        'admin_remarks',
        'submitted_at',
        'processed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    /* ---------- Auto-generate application number ---------- */

    protected static function booted(): void
    {
        static::creating(function (Application $application) {
            if (empty($application->application_number)) {
                $year = now()->format('Y');
                $lastId = static::max('id') ?? 0;
                $application->application_number = 'GOV-' . $year . '-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
            }
            if (empty($application->submitted_at)) {
                $application->submitted_at = now();
            }
        });
    }

    /* ---------- Relationships ---------- */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /* ---------- Helpers ---------- */

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'badge-pending',
            'under_review' => 'badge-under-review',
            'approved' => 'badge-approved',
            'rejected' => 'badge-rejected',
            'completed' => 'badge-completed',
            default => 'badge-secondary',
        };
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'under_review' => 'Under Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'completed' => 'Completed',
            default => ucfirst($this->status),
        };
    }
}
