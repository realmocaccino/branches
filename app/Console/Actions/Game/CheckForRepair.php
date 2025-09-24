<?php
namespace App\Console\Actions\Game;

use App\Site\Models\Game;

class CheckForRepair
{
	protected $games;
	
	public function __construct() {
    	$this->games = Game::all();
    }
    
    public function check()
    {
    	foreach($this->games as $game) {
    		$totalVerifiedRatings = $game->ratings()->whereHas('user')->count();
    		
    		if($game->total_ratings != $totalVerifiedRatings or $game->platforms()->sum('total') != $totalVerifiedRatings) {
    			(new RepairStats($game->slug))->repair();
    		}
    	}
    }
}
