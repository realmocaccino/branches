<?php
namespace App\Console\Jobs;

use App\Console\Actions\Misc\FlushIrrelevantCollections;

class FlushIrrelevantCollectionsJob
{
    public function handle(FlushIrrelevantCollections $action)
    {
        $action->run();
    }
}