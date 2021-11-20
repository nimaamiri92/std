<?php

namespace App\Services;

use App\Models\Question;

class QuestionService extends BaseService
{
    public function __construct(Question $question)
    {
        parent::__construct($question);
    }

    public function resetUserProgress()
    {
        $this->model
            ->newQuery()
            ->where('is_answered', Question::ANSWERED)
            ->update(['is_answered' => Question::NOT_ANSWERD]);
    }
}