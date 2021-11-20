<?php

namespace App\Console\Commands\QuestionAnswerApp;

use App\Console\Commands\QuestionAnswerApp\Steps\AddQuestionStep;
use App\Console\Commands\QuestionAnswerApp\Steps\AnswerQuestionsStep;
use App\Console\Commands\QuestionAnswerApp\Steps\ViewQuestionsStep;

final class Settings
{
    public const ADD_QUESTION_OPTION = [
        AddQuestionStep::STEP_LABEL => AddQuestionStep::STEP_DESCRIPTION,
    ];

    public const VIEW_QUESTION_OPTION = [
        ViewQuestionsStep::STEP_LABEL => ViewQuestionsStep::STEP_DESCRIPTION,
    ];

    public const ANSWER_QUESTION_OPTION = [
        AnswerQuestionsStep::STEP_LABEL => AnswerQuestionsStep::STEP_DESCRIPTION,
    ];

    //default settings
    public const EXIT_LABEL = 'exit';
    public const EXIT_DESCRIPTION = 'Exit!';

    public const BACK_LABEL = 'back';
    public const BACK_DESCRIPTION = 'Back to previous step?';

    public const DEFAULT_SYSTEM_OPTIONS = [
        self::BACK_LABEL => self::BACK_DESCRIPTION,
        self::EXIT_LABEL => self::EXIT_DESCRIPTION,
    ];
}