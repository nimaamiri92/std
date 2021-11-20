<?php

namespace App\Console\Commands\QuestionAnswerApp\Steps;

use App\Console\Commands\QuestionAnswerApp\AbstractCommand;
use App\Console\Commands\QuestionAnswerApp\Lang\Messages;
use App\Console\Commands\QuestionAnswerApp\Settings;

class WelcomeStep extends AbstractCommand implements StepInterface
{
    public const TITLE = 'Add Question/Answer or view the result';
    public const STEP_LABEL = 'welcome';

    protected $signature = 'qanda:interactive';

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
        return array_merge(
            Settings::ADD_QUESTION_OPTION,
            Settings::VIEW_QUESTION_OPTION,
        );
    }

    protected static function getPreviousStep(): string
    {
        return self::STEP_LABEL;
    }

    public function handle()
    {
        $this->clearScreen();

        $this->output->title(Messages::WELCOME_MESSAGE);
        $this->goNextStep();
    }
}
