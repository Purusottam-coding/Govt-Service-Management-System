<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ---------- Role Helpers ---------- */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCitizen(): bool
    {
        return $this->role === 'citizen';
    }

    /* ---------- Relationships ---------- */

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
