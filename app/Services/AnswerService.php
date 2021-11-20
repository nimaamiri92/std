<?php

namespace App\Services;

use App\Models\Answer;

class AnswerService extends BaseService
{
    public function __construct(Answer $question)
    {
        parent::__construct($question);
    }
}