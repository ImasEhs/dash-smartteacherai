<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
    protected $fillable = ['course_id', 'feedback_id', 'user_id', 'score', 'comments'];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
