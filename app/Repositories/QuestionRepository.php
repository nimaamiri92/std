<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository extends BaseRepository
{
    public function __construct(Question $question)
    {
        parent::__construct($question);
    }

    public function getSelectedQuestion(int $questionId): Question
    {
        return Question::where('id', $questionId)->with('answer')->first();
    }

    public function questionExist(int $questionId): bool
    {
        return Question::query()->where('id', $questionId)->exists();
    }
}