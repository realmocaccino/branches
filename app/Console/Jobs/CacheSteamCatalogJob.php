<?php
namespace App\Console\Jobs;

use App\Console\Actions\Misc\CacheSteamCatalog;

class CacheSteamCatalogJob
{
    public function handle(CacheSteamCatalog $action)
    {
        $action->run();
    }
}