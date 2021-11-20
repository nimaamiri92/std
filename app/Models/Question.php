<?php

namespace App\Models;

use App\Console\Commands\QuestionAnswerApp\Lang\Messages;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    const ANSWERED = 1;
    const NOT_ANSWERD = 0;

    protected $fillable = [
        'question',
        'is_answered',
    ];

    protected $appends = [
      'status'
    ];

    protected $hidden = [
        'is_answered',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => "datetime:Y-m-d",
    ];

    public function getStatusAttribute()
    {
        return $this->is_answered ? Messages::ANSWERED_QUESTION : Messages::NOT_ANSWERED_QUESTION;
    }

    public function answer()
    {
        return $this->hasOne(Answer::class);
    }
}
