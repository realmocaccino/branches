<?php
namespace App\Console\Commands;

use App\Console\Actions\Misc\FlushIrrelevantCollections;

use Illuminate\Console\Command;

class FlushIrrelevantCollectionsCommand extends Command
{
    protected $signature = 'collections:flush-irrelevant-collections';

    protected $description = 'Delete collections with less than 3 games and more than 1 month since its creation';

    private $action;
	
    public function __construct(FlushIrrelevantCollections $action)
    {
        parent::__construct();

        $this->action = $action;
    }

    public function handle()
    {
        $this->action->run();
    }
}