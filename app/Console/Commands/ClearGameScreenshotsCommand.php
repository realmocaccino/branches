<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\ClearScreenshots;

use Illuminate\Console\Command;

class ClearGameScreenshotsCommand extends Command
{
    protected $signature = 'game:clearScreenshots {gameSlug}';

    protected $description = 'Clear screenshots of a game';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new ClearScreenshots($this->argument('gameSlug'));
        $action->clear();
    }
}
