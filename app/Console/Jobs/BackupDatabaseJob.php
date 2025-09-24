<?php
namespace App\Console\Jobs;

use App\Console\Actions\Misc\BackupDatabase;

class BackupDatabaseJob
{
    public function handle()
    {
    	(new BackupDatabase)->run();
    }
}
