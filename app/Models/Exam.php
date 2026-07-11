<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'course_id', 'title', 'description', 'duration_minutes', 'max_attempts', 'randomize_questions', 'randomize_options', 'pass_score',
        'type', 'external_form_url', 'published_at', 'is_active'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
