<?php
namespace App\Console\Commands;

use App\Console\Actions\Rating\CheckForMissingCriteria;

use Illuminate\Console\Command;

class CheckForRatingsMissingCriteria extends Command
{
    protected $signature = 'ratings:checkForMissingCriteria';

    protected $description = 'Look for ratings that miss criteria then fix them';
	
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new CheckForMissingCriteria();
        $action->check();
    }
}
