<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'class_room_id',
        'date_of_birth',
        'gender',
        'address',
        'parent_name',
        'parent_phone',
        'is_active',
    ];
    
    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($student) {
            if (empty($student->student_id)) {
                $student->student_id = static::generateStudentId();
            }
        });
    }
    
    /**
     * Generate unique student ID with format MHBTNxxxx
     */
    public static function generateStudentId(): string
    {
        $prefix = 'MHBTN';
        
        // Get the last student ID with this prefix
        $lastStudent = static::where('student_id', 'like', $prefix . '%')
            ->orderBy('student_id', 'desc')
            ->first();
        
        if ($lastStudent) {
            // Extract the number part and increment
            $lastNumber = (int) substr($lastStudent->student_id, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        } else {
            // Start from 1 if no students exist
            $nextNumber = 1;
        }
        
        // Format with leading zeros (4 digits)
        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Get the classroom this student belongs to.
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }
    
    /**
     * Get all attendance records for this student.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(StudentAttendance::class);
    }
    
    /**
     * Scope a query to only include active students.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to filter by classroom.
     */
    public function scopeInClass($query, $classRoomId)
    {
        return $query->where('class_room_id', $classRoomId);
    }
    
    /**
     * Get full name with student ID.
     */
    public function getFullNameWithIdAttribute(): string
    {
        return "{$this->name} ({$this->student_id})";
    }
} 