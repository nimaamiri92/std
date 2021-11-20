<?php

namespace Tests\Integration\Repository;

use App\Models\Answer;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use App\Services\QuestionService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class QuestionServiceTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function test_rest_user_progress()
    {
        $question_one = factory(Question::class)->create(['is_answered' => Question::ANSWERED]);
        $answer_one   = factory(Answer::class)->create([
            'question_id' => $question_one->id,
        ]);
        $question_two = factory(Question::class)->create();
        $answer_two   = factory(Answer::class)->create([
            'question_id' => $question_two->id,
        ]);

        (new QuestionService(new Question))->resetUserProgress();

        $this->assertFalse(
            Question::query()->where('is_answered', Question::ANSWERED)->exists()
        );
    }
}