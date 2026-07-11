<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamOption extends Model
{
    protected $fillable = ['exam_question_id', 'option_text', 'is_correct', 'order'];

    public function exam_question()
    {
        return $this->belongsTo(ExamQuestion::class);
    }
}
