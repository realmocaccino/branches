<?php
namespace App\Console\Commands;

use App\Site\Models\Game;
use App\Console\Exceptions\NoApiGameFoundException;

use Illuminate\Console\Command;

class SearchForReleaseDateOfUpcomingGamesCommand extends Command
{
    protected $signature = 'games:searchForReleaseDateOfUpcomingGames {--force}';

    protected $description = 'Search for release date of games without one';
    
    protected $upcomingGames;

    public function __construct(Game $game)
    {
        parent::__construct();

        $this->upcomingGames = $game->whereNull('release')->get();
    }

    public function handle()
    {
        foreach($this->upcomingGames as $game) {
            try {
                $this->call('game:fetchReleaseDate', [
                    'gameSlug' => $game->slug,
                    '--force' => $this->option('force')
                ]);
            } catch(NoApiGameFoundException $exception) {
                $this->error($exception->getMessage());
            }
    	}
    }
}
