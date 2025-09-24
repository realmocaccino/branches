<?php
namespace App\Console\Commands;

use App\Console\Actions\User\CheckForRepair;

use Illuminate\Console\Command;

class CheckForRepairUsersCommand extends Command
{
    protected $signature = 'users:checkForRepair';

    protected $description = 'Check and Repair users stats';
	
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
