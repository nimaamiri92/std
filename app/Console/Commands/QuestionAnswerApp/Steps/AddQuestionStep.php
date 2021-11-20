<?php

namespace App\Console\Commands\QuestionAnswerApp\Steps;

use App\Console\Commands\QuestionAnswerApp\AbstractCommand;
use App\Console\Commands\QuestionAnswerApp\Lang\Messages;
use App\Console\Commands\QuestionAnswerApp\Settings;
use App\Services\QuestionService;

class AddQuestionStep extends AbstractCommand
{
    public const TITLE = 'Please add your question and desired answer';
    public const STEP_LABEL = 'add-question';
    public const STEP_DESCRIPTION = 'Add Question/Answer';

    protected $signature = 'qanda:add-question';

    protected $hidden = true;

    private QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        parent::__construct();
        $this->questionService = $questionService;
    }

    public function isApplicable(string $step): bool
    {
        return self::STEP_LABEL === $step;
    }

    protected static function getMenuTitle(): string
    {
        return self::TITLE;
    }

    protected static function getMenuOptions(): array
    {
        return Settings::ADD_QUESTION_OPTION;
    }

    protected static function getPreviousStep(): string
    {
        return WelcomeStep::STEP_LABEL;
    }

    public function handle()
    {
        $question = $this->getQuestion();
        $answer   = $this->getAnswer();
        $this->saveQuestionAndAnswer($question, $answer);

        $this->goNextStep(ViewQuestionsStep::STEP_LABEL);
    }

    /***************************************************************************************************
     *                                     private properties                                          *
     ***************************************************************************************************/

    private function getQuestion(): string
    {
        do {
            $question = $this->ask(Messages::GET_QUESTION);
        } while ($question === null);

        return strtolower($question);
    }

    private function getAnswer(): string
    {
        do {
            $answer = $this->ask(Messages::GET_ANSWER);
        } while ($answer === null);

        return strtolower($answer);
    }

    private function saveQuestionAndAnswer($question, $answer): void
    {
        $this->questionService->store(['question' => $question])
                              ->answer()->create(['answer' => $answer]);
    }
}