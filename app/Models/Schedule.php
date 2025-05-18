<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_active',
        'is_exception',
        'exception_date',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
        'is_exception' => 'boolean',
        'exception_date' => 'date',
    ];
    
    /**
     * Get the user that owns the schedule.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Scope a query to only include active schedules.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to only include schedules for a specific day of the week.
     */
    public function scopeForDayOfWeek($query, $dayOfWeek)
    {
        return $query->where('day_of_week', $dayOfWeek);
    }
    
    /**
     * Scope a query to only include schedules for current day of the week.
     */
    public function scopeForToday($query)
    {
        return $query->where('day_of_week', now()->dayOfWeek);
    }
    
    /**
     * Scope a query to only include regular (non-exception) schedules.
     */
    public function scopeRegular($query)
    {
        return $query->where('is_exception', false);
    }
    
    /**
     * Scope a query to only include exception schedules.
     */
    public function scopeExceptions($query)
    {
        return $query->where('is_exception', true);
    }
}
