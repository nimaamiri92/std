<?php

namespace App\Providers;

use App\Console\Commands\QuestionAnswerApp\Steps\AddQuestionStep;
use App\Console\Commands\QuestionAnswerApp\Steps\AnswerQuestionsStep;
use App\Console\Commands\QuestionAnswerApp\Steps\WelcomeStep;
use App\Console\Commands\QuestionAnswerApp\Steps\ViewQuestionsStep;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class QuestionAndAnswerProvider extends ServiceProvider
{
    private const COMMAND_TAGS = [
        AddQuestionStep::class,
        AnswerQuestionsStep::class,
        WelcomeStep::class,
        ViewQuestionsStep::class,
    ];

    public function register()
    {
        $this->app->tag(static::COMMAND_TAGS, 'command.tags');

        $this->app->singleton('stepList', function (Container $app) {
            return $app->tagged('command.tags');
        });
    }
}