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
                $date = now()->format('Ymd');
                $lastId = static::max('id') ?? 0;
                $application->application_number = 'GOV-' . $date . '-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
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
            'pending' => 'पेश गरिएको',
            'under_review' => 'छानबिनमा',
            'approved' => 'स्वीकृत',
            'rejected' => 'अस्वीकृत',
            'completed' => 'सम्पन्न',
            default => ucfirst($this->status),
        };
    }

    public function canBeEdited(): bool
    {
        return $this->canBeEditedOrDeleted();
    }

    public function canBeDeleted(): bool
    {
        return $this->canBeEditedOrDeleted();
    }

    public function canBeEditedOrDeleted(): bool
    {
        // Cannot edit or delete once application is no longer in pending status
        if ($this->status !== 'pending') {
            return false;
        }

        // Cannot edit or delete if payment has been made (completed) or is pending verification
        if ($this->payment && in_array($this->payment->status, ['completed', 'pending'])) {
            return false;
        }

        return true;
    }
}