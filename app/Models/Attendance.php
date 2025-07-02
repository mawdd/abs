<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date',
        'check_in_time',
        'check_out_time',
        'check_in_location',
        'check_out_location',
        'check_in_location_valid',
        'check_out_location_valid',
        'check_in_device_info',
        'check_out_device_info',
        'status',
        'is_holiday',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'check_in_location' => 'json',
        'check_out_location' => 'json',
        'check_in_location_valid' => 'boolean',
        'check_out_location_valid' => 'boolean',
        'is_holiday' => 'boolean',
    ];
    
    /**
     * Get the user that owns the attendance.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Scope a query to only include attendances for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }
    
    /**
     * Scope a query to only include today's attendances.
     */
    public function scopeForToday($query)
    {
        return $query->where('date', now()->toDateString());
    }
    
    /**
     * Check if the attendance is checked in.
     */
    public function isCheckedIn(): bool
    {
        return $this->check_in_time !== null;
    }
    
    /**
     * Check if the attendance is checked out.
     */
    public function isCheckedOut(): bool
    {
        return $this->check_out_time !== null;
    }
    
    /**
     * Check if the attendance is complete.
     */
    public function isComplete(): bool
    {
        return $this->isCheckedIn() && $this->isCheckedOut();
    }
}
