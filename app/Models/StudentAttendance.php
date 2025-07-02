<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAttendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'teaching_session_id',
        'student_id',
        'status',
        'notes',
    ];
    
    /**
     * Get the teaching session for this attendance.
     */
    public function teachingSession(): BelongsTo
    {
        return $this->belongsTo(TeachingSession::class);
    }
    
    /**
     * Get the student for this attendance.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    
    /**
     * Scope a query to only include present students.
     */
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }
    
    /**
     * Scope a query to only include absent students.
     */
    public function scopeAbsent($query)
    {
        return $query->whereIn('status', ['absent_with_permission', 'absent_without_permission']);
    }
    
    /**
     * Scope a query to only include sick students.
     */
    public function scopeSick($query)
    {
        return $query->where('status', 'sick');
    }
    
    /**
     * Check if the student is present.
     */
    public function isPresent(): bool
    {
        return $this->status === 'present';
    }
    
    /**
     * Check if the student is absent.
     */
    public function isAbsent(): bool
    {
        return in_array($this->status, ['absent_with_permission', 'absent_without_permission']);
    }
    
    /**
     * Get the status label for display.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'present' => __('Present'),
            'sick' => __('Sick'),
            'absent_with_permission' => __('Absent with Permission'),
            'absent_without_permission' => __('Absent without Permission'),
            default => ucfirst($this->status),
        };
    }
} 