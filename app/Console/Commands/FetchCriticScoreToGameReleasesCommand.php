<?php
namespace App\Console\Commands;

use App\Site\Models\Game;

use Illuminate\Console\Command;

class FetchCriticScoreToGameReleasesCommand extends Command
{
    protected $signature = 'games:fetchCriticScoreToGameReleases';

    protected $description = 'Fetch critic score for recent games';
    
    protected $api;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $games = Game::whereBetween('release', [now()->subMonth(), now()->addDays(7)])->orderBy('release', 'desc')->get();
        
        if(count($games)) {
        	foreach($games as $game) {
        		$this->call('game:fetchCriticScore', [
        			'gameSlug' => $game->slug
        		]);
        	}
        } else {
        	echo "Nenhum jogo para buscar nota!\n";
        }
    }
}