<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Course extends Model
{
    protected $fillable = ['title', 'slug', 'image', 'category_id', 'user_id', 'price', 'discount', 'description', 'status'];

    // protected function image(): Attribute
    // {
    //      return Attribute::make(
    //         get: function ($image) {
    //             if (!$image || trim($image) === '') {
    //                 return null;
    //             }

    //             $path = "courses/{$image}";
    //             return Storage::disk('public')->exists($path)
    //                 ? asset("storage/{$path}")
    //                 : null;
    //         },
    //     );
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function course_videos()
    {
        return $this->hasMany(CourseVideo::class);
    }

    public function course_latest_video()
    {
        return $this->hasOne(CourseVideo::class)->orderBy('episode', 'desc');
    }

    public function course_users()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function course_reviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
    
    public function cert()
    {
        return $this->belongsTo(CourseCertificateTemplate::class , 'id' , 'course_id');
    }
}
