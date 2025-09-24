<?php
namespace App\Common\Models;

class Franchise extends Base
{
    protected $table = 'franchises';
    
    public function games()
	{
		return $this->belongsToMany(Game::class, 'franchise_game', 'franchise_id', 'game_id')->withTimestamps();
	}

	public function scopeWithMoreThanTwoGames($query)
	{
		return $query->has('games', '>', 2);
	}
}
