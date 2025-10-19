<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_number',
        'name',
        'email',
        'phone',
        'account_number',
        'category',
        'priority',
        'subject',
        'description',
        'attachments',
        'status',
        'assigned_to',
        'admin_notes',
        'resolved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attachments' => 'array',
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = 'TKT-' . strtoupper(uniqid());
            }
        });
    }

    /**
     * Get the status badge color.
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'open' => 'primary',
            'in_progress' => 'warning',
            'resolved' => 'success',
            'closed' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get the priority badge color.
     *
     * @return string
     */
    public function getPriorityColorAttribute()
    {
        return match ($this->priority) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get the category display name.
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return match ($this->category) {
            'no-connection' => 'No Internet Connection',
            'slow-connection' => 'Slow/Intermittent Connection',
            'billing' => 'Billing & Payment Inquiry',
            'installation' => 'Installation Request',
            'equipment' => 'Equipment Issue',
            'upgrade' => 'Plan Upgrade/Downgrade',
            'cancellation' => 'Service Cancellation',
            'other' => 'Other Technical Issues',
            default => $this->category,
        };
    }

    /**
     * Scope a query to only include tickets with a given status.
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
     * Scope a query to only include tickets with a given priority.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $priority
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to only include open tickets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['open', 'in_progress']);
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
     * Check if ticket is open.
     *
     * @return bool
     */
    public function isOpen()
    {
        return in_array($this->status, ['open', 'in_progress']);
    }

    /**
     * Check if ticket is resolved.
     *
     * @return bool
     */
    public function isResolved()
    {
        return $this->status === 'resolved';
    }

    /**
     * Check if ticket is closed.
     *
     * @return bool
     */
    public function isClosed()
    {
        return $this->status === 'closed';
    }

    /**
     * Mark ticket as resolved.
     *
     * @return void
     */
    public function markAsResolved()
    {
        $this->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
    }

    /**
     * Mark ticket as closed.
     *
     * @return void
     */
    public function markAsClosed()
    {
        $this->update([
            'status' => 'closed',
        ]);
    }
}
