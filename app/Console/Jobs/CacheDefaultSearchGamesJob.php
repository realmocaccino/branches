<?php
namespace App\Console\Jobs;

use App\Site\Services\DefaultSearchGamesService;

class CacheDefaultSearchGamesJob
{
    public function handle(DefaultSearchGamesService $defaultSearchGamesService)
    {
        return $defaultSearchGamesService->cache();
    }
}