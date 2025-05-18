<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
    ];
    
    /**
     * Get the schedules for this subject.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }
    
    /**
     * Get the teachers who teach this subject.
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(TeacherProfile::class, 'teacher_subjects');
    }
}
