<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'capacity',
        'location',
    ];
    
    protected $casts = [
        'capacity' => 'integer',
    ];
    
    /**
     * Get the schedules for this classroom.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }
    
    /**
     * Get the students in this classroom.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
    
    /**
     * Get the teaching sessions in this classroom.
     */
    public function teachingSessions(): HasMany
    {
        return $this->hasMany(TeachingSession::class);
    }
}
