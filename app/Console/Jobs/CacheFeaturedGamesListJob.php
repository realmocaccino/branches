<?php
namespace App\Console\Jobs;

use App\Console\Actions\Misc\CacheFeaturedGamesList;

class CacheFeaturedGamesListJob
{
    public function handle(CacheFeaturedGamesList $action)
    {
        $action->handle();
    }
}