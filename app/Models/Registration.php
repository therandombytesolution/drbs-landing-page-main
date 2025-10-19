<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registration_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'alternate_phone',
        'building',
        'floor',
        'unit',
        'tower',
        'full_address',
        'plan',
        'preferred_date',
        'referral_code',
        'notes',
        'documents',
        'agree_terms',
        'agree_marketing',
        'status',
        'contacted_at',
        'scheduled_at',
        'installed_at',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'documents' => 'array',
        'agree_terms' => 'boolean',
        'agree_marketing' => 'boolean',
        'preferred_date' => 'date',
        'contacted_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'installed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->registration_number)) {
                $registration->registration_number = 'REG-' . strtoupper(uniqid());
            }
        });
    }

    /**
     * Get the full name attribute.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the plan display name.
     *
     * @return string
     */
    public function getPlanNameAttribute()
    {
        return match ($this->plan) {
            '10mbps' => '10 Mbps - Starter',
            '25mbps' => '25 Mbps - Standard',
            '50mbps' => '50 Mbps - Premium',
            default => $this->plan,
        };
    }

    /**
     * Get the plan price.
     *
     * @return int
     */
    public function getPlanPriceAttribute()
    {
        return match ($this->plan) {
            '10mbps' => 900,
            '25mbps' => 1500,
            '50mbps' => 2500,
            default => 0,
        };
    }

    /**
     * Get the status badge color.
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'contacted' => 'info',
            'scheduled' => 'primary',
            'installed' => 'success',
            'active' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get the status display name.
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        return match ($this->status) {
            'pending' => 'Pending Review',
            'contacted' => 'Contacted',
            'scheduled' => 'Installation Scheduled',
            'installed' => 'Installed',
            'active' => 'Active Subscriber',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    /**
     * Scope a query to only include registrations with a given status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include pending registrations.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include active registrations.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to order by latest first.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Check if registration is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if registration is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if registration is cancelled.
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Mark registration as contacted.
     *
     * @return void
     */
    public function markAsContacted()
    {
        $this->update([
            'status' => 'contacted',
            'contacted_at' => now(),
        ]);
    }

    /**
     * Mark registration as scheduled.
     *
     * @param  \DateTime  $scheduledDate
     * @return void
     */
    public function markAsScheduled($scheduledDate)
    {
        $this->update([
            'status' => 'scheduled',
            'scheduled_at' => $scheduledDate,
        ]);
    }

    /**
     * Mark registration as installed.
     *
     * @return void
     */
    public function markAsInstalled()
    {
        $this->update([
            'status' => 'installed',
            'installed_at' => now(),
        ]);
    }

    /**
     * Mark registration as active.
     *
     * @return void
     */
    public function markAsActive()
    {
        $this->update([
            'status' => 'active',
        ]);
    }

    /**
     * Cancel registration.
     *
     * @return void
     */
    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }
}
