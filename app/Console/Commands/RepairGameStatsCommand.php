<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\RepairStats;

use Illuminate\Console\Command;

class RepairGameStatsCommand extends Command
{
    protected $signature = 'game:repairStats {gameSlug}';

    protected $description = 'Repair game stats like score, totalizers and its relationships';
	
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new RepairStats($this->argument('gameSlug'));
        $action->repair();
    }
}