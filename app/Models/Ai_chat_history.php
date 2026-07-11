<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ai_chat_history extends Model
{
    use HasFactory;

    protected $table = 'ai_chat_history';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'question',
        'answer',
    ];
}
