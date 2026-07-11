<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    protected $fillable = ['course_id', 'name', 'slug', 'episode', 'video_code', 'is_free'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
