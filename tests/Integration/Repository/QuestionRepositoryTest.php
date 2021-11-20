<?php

namespace Tests\Integration\Repository;

use App\Models\Answer;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class QuestionRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function test_get_selected_question()
    {
        $question_one = factory(Question::class)->create();
        $answer_one   = factory(Answer::class)->create([
            'question_id' => $question_one->id,
        ]);
        $question_two = factory(Question::class)->create();
        $answer_two   = factory(Answer::class)->create([
            'question_id' => $question_two->id,
        ]);

        $questionOneData = (new QuestionRepository(new Question))->getSelectedQuestion($question_one->id);

        $this->assertEquals($question_one->id, $questionOneData->id);
    }

    public function test_question_exist()
    {
        $question_one = factory(Question::class)->create();
        $answer_one   = factory(Answer::class)->create([
            'question_id' => $question_one->id,
        ]);
        $question_two = factory(Question::class)->create();
        $answer_two   = factory(Answer::class)->create([
            'question_id' => $question_two->id,
        ]);

        $questionOneData = (new QuestionRepository(new Question))->questionExist($question_one->id);

        $this->assertTrue($questionOneData);
    }
}