<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceRegistration extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'device_identifier',
        'device_details',
        'is_active',
        'last_used_at',
        'approved_at',
        'approved_by',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'device_details' => 'json',
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'approved_at' => 'datetime',
    ];
    
    /**
     * Get the user that owns the device registration.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the admin who approved the device registration.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    /**
     * Scope a query to only include active device registrations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to only include approved device registrations.
     */
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }
    
    /**
     * Scope a query to only include pending device registrations.
     */
    public function scopePending($query)
    {
        return $query->whereNull('approved_at');
    }
    
    /**
     * Check if device registration is approved.
     */
    public function isApproved(): bool
    {
        return $this->approved_at !== null;
    }
}
