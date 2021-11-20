<?php

namespace App\Console\Commands\QuestionAnswerApp\Steps;

interface StepInterface
{
    public function isApplicable(string $step): bool;
}