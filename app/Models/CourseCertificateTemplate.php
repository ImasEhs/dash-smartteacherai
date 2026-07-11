<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCertificateTemplate extends Model
{
    protected $fillable = ['course_id', 'image', 'orientation', 'page_size', 'fields'];

    protected $casts = ['fields' => 'array'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
