<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    protected $fillable = ['exam_attempt_id', 'exam_question_id', 'selected_option_id', 'answer_text', 'score_awarded', 'graded_by', 'graded_at'];

    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'exam_attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'exam_question_id');
    }

    public function option()
    {
        return $this->belongsTo(ExamOption::class, 'selected_option_id');
    }
}
