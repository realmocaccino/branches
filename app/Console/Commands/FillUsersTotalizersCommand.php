<?php
namespace App\Console\Commands;

use App\Console\Actions\User\FillTotalizers;

use Illuminate\Console\Command;

class FillUsersTotalizersCommand extends Command
{
    protected $signature = 'users:fillTotalizers';

    protected $description = 'Fill totalizers to all users';
	
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new FillTotalizers();
        $action->fill();
    }
}
