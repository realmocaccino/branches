<?php
namespace App\Console\Jobs;

use App\Console\Actions\Misc\FlushCacheDirectory;

class FlushCacheDirectoryJob
{
    public function handle()
    {
        (new FlushCacheDirectory())->run();
    }
}
