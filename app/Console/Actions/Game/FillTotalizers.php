<?php
namespace App\Console\Actions\Game;

use App\Site\Models\Game;

class FillTotalizers
{
    public function __construct() {}

    public function fill()
    {
        foreach(Game::all() as $game) {
			$game->total_ratings = $game->ratings()->count();
			$game->total_reviews = $game->reviews()->count();
			$game->timestamps = false;
			$game->save();
		}
    }
}