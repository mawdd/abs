<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Holiday extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'name',
        'description',
        'type',
        'is_active',
        'created_by',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the user who created the holiday.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Scope a query to only include active holidays.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to only include holidays of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
    
    /**
     * Scope a query to only include holidays for a specific date range.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
    
    /**
     * Scope a query to only include holidays for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }
    
    /**
     * Scope a query to only include today's holidays.
     */
    public function scopeForToday($query)
    {
        return $query->where('date', now()->toDateString());
    }
    
    /**
     * Check if a given date is a holiday.
     */
    public static function isHoliday($date): bool
    {
        return static::active()->forDate($date)->exists();
    }
}
