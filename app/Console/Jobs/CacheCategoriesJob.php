<?php
namespace App\Console\Jobs;

use App\Console\Actions\Misc\CacheCategories;

class CacheCategoriesJob
{
    public function handle(CacheCategories $action)
    {
        $action->handle();
    }
}