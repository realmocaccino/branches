<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\CheckForRepair;

use Illuminate\Console\Command;

class CheckForRepairGamesCommand extends Command
{
    protected $signature = 'games:checkForRepair';

    protected $description = 'Check and Repair games stats like score, totalizers and its relationships';
	
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new CheckForRepair();
        $action->check();
    }
}
