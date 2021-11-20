<?php

namespace App\Console\Commands\QuestionAnswerApp\Steps;

use App\Console\Commands\QuestionAnswerApp\AbstractCommand;
use App\Console\Commands\QuestionAnswerApp\Lang\Messages;
use App\Console\Commands\QuestionAnswerApp\Settings;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use App\Services\QuestionService;

class AnswerQuestionsStep extends AbstractCommand
{
    public const TITLE = 'Here you can answer questions:';
    public const STEP_LABEL = 'answer';
    public const STEP_DESCRIPTION = 'answer a question';

    protected $signature = 'qanda:answer-question';

    protected $hidden = true;

    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository, QuestionService $questionService)
    {
        parent::__construct();
        $this->questionRepository = $questionRepository;
        $this->questionService    = $questionService;
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
        return Settings::ANSWER_QUESTION_OPTION;
    }

    protected static function getPreviousStep(): string
    {
        return AddQuestionStep::STEP_LABEL;
    }

    public function handle()
    {
        $questionId = $this->getUserSelectedQuestion();

        $userAnswer    = $this->getUserAnswer();
        $correctAnswer = $this->getCorrectAnswer($questionId);

        if ($correctAnswer === $userAnswer) {
            $this->markQuestionAsAnswered($questionId);
        }

        $this->clearScreen();
        $this->goNextStep(ViewQuestionsStep::STEP_LABEL);
    }

    /***************************************************************************************************
     *                                     private properties                                          *
     ***************************************************************************************************/

    private function getUserAnswer()
    {
        do {
            $answer = $this->ask(Messages::GET_CORRECT_ANSWER);
        } while ($answer === null);

        return strtolower($answer);
    }

    private function getUserSelectedQuestion(): int
    {
        while (true) {
            $questionId = $this->ask(Messages::SELECT_QUESTION);

            if ($this->questionRepository->questionExist($questionId)) {
                break;
            }

            $this->output->caution(Messages::QUESTION_NOT_FOUND);
        }

        return $questionId;
    }

    private function getCorrectAnswer(int $questionId): string
    {
        return $this->questionRepository->getSelectedQuestion($questionId)->answer->answer;
    }

    protected function markQuestionAsAnswered(int $questionId): void
    {
        $this->questionService->update(['is_answered' => Question::ANSWERED], $questionId);
    }
}