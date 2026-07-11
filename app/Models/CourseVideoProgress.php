<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseVideoProgress extends Model
{
    protected $fillable = [
        'user_id','course_video_id','progress_percent','is_completed','current_second','duration_second'
    ];

    protected $casts = [
        'progress_percent' => 'float',
        'is_completed'     => 'boolean',
        'current_second'   => 'integer',
        'duration_second'  => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(CourseVideo::class);
    }
}
