<?php

namespace App\Console\Commands;

use App\Services\QuestionService;
use Illuminate\Console\Command;

class RestQuestionAnswerCommand extends Command
{

    protected $signature = 'qanda:reset';

    protected $description = 'reset the entire application';

    private QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        parent::__construct();
        $this->questionService = $questionService;
    }

    public function handle()
    {
        $this->questionService->resetUserProgress();
        $this->output->success('application reset successfully');
    }
}
