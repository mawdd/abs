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
        'title',
        'date',
        'description',
        'is_recurring',
        'is_national_holiday',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'is_recurring' => 'boolean',
        'is_national_holiday' => 'boolean',
    ];
    
    /**
     * Scope a query to only include national holidays.
     */
    public function scopeNational($query)
    {
        return $query->where('is_national_holiday', true);
    }
    
    /**
     * Scope a query to only include school-specific holidays.
     */
    public function scopeSchoolSpecific($query)
    {
        return $query->where('is_national_holiday', false);
    }
    
    /**
     * Scope a query to only include recurring holidays.
     */
    public function scopeRecurring($query)
    {
        return $query->where('is_recurring', true);
    }
    
    /**
     * Scope a query to only include non-recurring holidays.
     */
    public function scopeNonRecurring($query)
    {
        return $query->where('is_recurring', false);
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
        $dateObj = is_string($date) ? new \DateTime($date) : $date;
        $formattedDate = $dateObj->format('Y-m-d');
        
        // Check for exact date match
        $exactMatch = static::where('date', $formattedDate)->exists();
        if ($exactMatch) {
            return true;
        }
        
        // Check for recurring holidays (matching month and day)
        $monthDay = $dateObj->format('m-d');
        return static::recurring()
            ->whereRaw("DATE_FORMAT(date, '%m-%d') = ?", [$monthDay])
            ->exists();
    }
}
