<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\FillTotalizers;

use Illuminate\Console\Command;

class FillGamesTotalizersCommand extends Command
{
    protected $signature = 'games:fillTotalizers';

    protected $description = 'Fill totalizers to all games';
	
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
