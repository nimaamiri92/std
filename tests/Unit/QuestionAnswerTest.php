<?php

namespace Tests\Unit;

use App\Console\Commands\QuestionAnswerApp\Lang\Messages;
use App\Console\Commands\QuestionAnswerApp\Settings;
use App\Console\Commands\QuestionAnswerApp\Steps\AddQuestionStep;
use App\Console\Commands\QuestionAnswerApp\Steps\AnswerQuestionsStep;
use App\Console\Commands\QuestionAnswerApp\Steps\ViewQuestionsStep;
use App\Console\Commands\QuestionAnswerApp\Steps\WelcomeStep;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class QuestionAnswerTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function test_user_can_see_welcome_step_menu_and_exit()
    {
        $this->artisan('qanda:interactive')
            ->expectsQuestion(WelcomeStep::TITLE,'exit')
            ->expectsQuestion(Messages::EXIT_CONFORMATION,'yes')
            ->assertExitCode(0);
    }

    public function test_user_can_see_back_to_previous_step()
    {
        $this->artisan('qanda:interactive')
             ->expectsQuestion(WelcomeStep::TITLE, 'view-questions')
            ->expectsQuestion(ViewQuestionsStep::TITLE,'back')
            ->expectsQuestion(WelcomeStep::TITLE,'exit')
            ->expectsQuestion(Messages::EXIT_CONFORMATION,'yes')
            ->assertExitCode(0);
    }

    public function test_user_can_add_question()
    {
        $question = '::question::';
        $answer   = '::answer::';

        $this->artisan('qanda:interactive')
             ->expectsQuestion(WelcomeStep::TITLE, AddQuestionStep::STEP_LABEL)
             ->expectsQuestion(Messages::GET_QUESTION, $question)
             ->expectsQuestion(Messages::GET_ANSWER, $answer)
             ->expectsQuestion(ViewQuestionsStep::TITLE, Settings::EXIT_LABEL)
             ->expectsQuestion(Messages::EXIT_CONFORMATION, 'yes')
             ->assertExitCode(0);

        $this->assertDatabaseHas('questions', ['question' => $question]);
        $this->assertDatabaseHas('answers', ['answer' => $answer]);
    }

    public function test_user_can_answer_question()
    {
        $question = factory(Question::class)->create();
        $answer   = factory(Answer::class)->create([
            'question_id' => $question->id,
        ]);

        $this->artisan('qanda:interactive')
             ->expectsQuestion(WelcomeStep::TITLE, ViewQuestionsStep::STEP_LABEL)
             ->expectsQuestion(ViewQuestionsStep::TITLE, AnswerQuestionsStep::STEP_LABEL)
             ->expectsQuestion(Messages::SELECT_QUESTION, $question->id)
             ->expectsQuestion(Messages::GET_CORRECT_ANSWER, $answer->answer)
             ->expectsQuestion(ViewQuestionsStep::TITLE, Settings::EXIT_LABEL)
             ->expectsQuestion(Messages::EXIT_CONFORMATION, 'yes')
             ->assertExitCode(0);
    }

    public function test_reset_application()
    {
        $question = factory(Question::class)->create(['is_answered' => Question::ANSWERED]);
        $answer = factory(Answer::class)->create([
            'question_id' => $question->id,
        ]);

        $this->artisan('qanda:reset')->run();

        $this->assertDatabaseHas('questions',['is_answered' => Question::NOT_ANSWERD]);
    }
}
