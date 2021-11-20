<?php

namespace App\Console\Commands\QuestionAnswerApp\Steps;

use App\Console\Commands\QuestionAnswerApp\AbstractCommand;
use App\Console\Commands\QuestionAnswerApp\Settings;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use Illuminate\Support\Collection;

class ViewQuestionsStep extends AbstractCommand
{
    public const TITLE = 'Here in above table we show you question list an your progress';
    public const STEP_LABEL = 'view-questions';
    public const STEP_DESCRIPTION = 'Get Answers/question list';

    protected $signature = 'qanda:view-questions';

    protected $hidden = true;

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
        return array_merge(Settings::ANSWER_QUESTION_OPTION, Settings::ADD_QUESTION_OPTION);
    }

    protected static function getPreviousStep(): string
    {
        return WelcomeStep::STEP_LABEL;
    }

    public function handle(QuestionRepository $questionRepository)
    {
        $this->clearScreen();
        $questions = $questionRepository->all();

        $this->showQuestionTable($questions);
        $this->showProgressBar(
            $questions->count(),
            $this->getCountOfAnsweredQuestions($questions)
        );

        $this->goNextStep();
    }

    /***************************************************************************************************
     *                                     private properties                                          *
     ***************************************************************************************************/

    private function getCountOfAnsweredQuestions($questions): int
    {
        return $questions->where('is_answered', Question::ANSWERED)->count();
    }

    private function showQuestionTable(Collection $questions): void
    {
        $this->table(
            ['id', 'question', 'created_at', 'status'],
            $questions,
            'box-double'
        );
    }

    private function showProgressBar(int $totalQuestions, int $totalAnsweredQuestions): void
    {
        $progress = $this->output->createProgressBar($totalQuestions);
        $progress->setProgress($totalAnsweredQuestions);
        $progress->display();
    }
}