<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $fillable = ['exam_id', 'type', 'question_text', 'points', 'order', 'is_active', 'answer_key_text', 'explanation'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function options()
    {
        return $this->hasMany(ExamOption::class)->orderBy('order');
    }
}
