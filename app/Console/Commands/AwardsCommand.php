<?php
namespace App\Console\Commands;

use App\Console\Helpers\AwardsHelper;

use Illuminate\Console\Command;

class AwardsCommand extends Command
{
    protected $signature = 'site:awards {year} {category?}';

    protected $description = 'The best games by year';

    protected $awardsHelper;

    public function __construct(AwardsHelper $awardsHelper)
    {
        parent::__construct();

        $this->awardsHelper = $awardsHelper;
    }

    public function handle()
    {
        $year = $this->argument('year');
        $category = $this->argument('category');

        if($category) {
            $this->printAward($year, $category);
        } else {
            while(true) {
                $this->printAward($year, $this->ask('Category'));
            }
        }
    }

    private function printAward($year, $category)
    {
        $games = $this->awardsHelper->getGames($year, $category);

        if($games) {
            if($games->count()) {
                $this->info("The best {$category} games of {$year}:");
                foreach($games as $game) {
                    echo "{$game->name} ({$game->score}) ({$game->total_ratings})" . PHP_EOL;
                }
            } else {
                $this->error("No {$category} games found for {$year}");
            }
        } else {
            $this->error("Invalid category");
        }
    }
}