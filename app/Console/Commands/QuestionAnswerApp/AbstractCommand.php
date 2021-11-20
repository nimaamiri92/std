<?php

namespace App\Console\Commands\QuestionAnswerApp;

use App\Console\Commands\QuestionAnswerApp\Lang\Messages;
use Illuminate\Console\Command;

abstract class AbstractCommand extends Command
{
    private $stepList;

    public function __construct()
    {
        parent::__construct();
        $this->stepList = app('stepList'); //register by service provider
    }

    protected function goNextStep(?string $step = null)
    {
        $selectedOption = $this->getUserSelectedOption($step);

        $this->checkUserWantToExit($selectedOption);
        $this->checkUserWantToGoBack($selectedOption);

        foreach ($this->stepList as $eachStep) {
            if ($eachStep->isApplicable($selectedOption)) {
                $this->call($eachStep->signature);
            }
        }
    }

    abstract protected static function getMenuTitle(): string;

    abstract protected static function getMenuOptions(): array;

    abstract protected static function getPreviousStep(): string;

    /***********************************************************************************
     *                        private function                                         *
     ***********************************************************************************/

    private static function stepOptions(): array
    {
        return array_merge(
            static::getMenuOptions(),
            Settings::DEFAULT_SYSTEM_OPTIONS
        );
    }

    private function loadCurrentStepTitleAndMenuOptions(): string
    {
        return $this->choice(static::getMenuTitle(), static::stepOptions());
    }

    private function getUserSelectedOption(?string $step): string
    {
        if ($step) {
            return $step;
        }

        return $this->loadCurrentStepTitleAndMenuOptions();
    }

    private function exit(): void
    {
        if ($this->confirm(Messages::EXIT_CONFORMATION)) {
            $this->clearScreen();
            return;
        }

        $this->goNextStep(static::STEP_LABEL);
    }

    private function checkUserWantToExit(string $selectedOption): void
    {
        if ($selectedOption === Settings::EXIT_LABEL) {
            $this->exit();
        }
    }

    private function checkUserWantToGoBack(string $selectedOption): void
    {
        if ($selectedOption === Settings::BACK_LABEL) {
            $this->clearScreen();
            $this->goNextStep(static::getPreviousStep());
        }
    }

    protected function clearScreen()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');
        } else {
            system('clear');
        }
    }
}