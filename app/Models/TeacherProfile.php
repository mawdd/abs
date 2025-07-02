<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeacherProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'qualification',
        'bio',
        'specialization',
        'profile_photo',
    ];

    protected $with = ['user'];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subjects taught by this teacher.
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects');
    }

    /**
     * String representation of the model for display purposes.
     */
    public function __toString(): string
    {
        // Ensure the user relationship is loaded
        if (!$this->relationLoaded('user')) {
            $this->load('user');
        }
        
        return $this->user?->name ?? 'Teacher #' . $this->id;
    }
}
