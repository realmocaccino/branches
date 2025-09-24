<?php
namespace App\Console\Commands;

use App\Console\Actions\User\RepairStats;

use Illuminate\Console\Command;

class RepairUserStatsCommand extends Command
{
    protected $signature = 'user:repairStats {userSlug}';

    protected $description = 'Repair user stats like total of ratings and total of reviews';
	
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new RepairStats($this->argument('userSlug'));
        $action->repair();
    }
}
