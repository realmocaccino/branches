<?php
namespace App\Common\Models;

class Characteristic extends Base
{
    protected $table = 'characteristics';

    public function games()
	{
		return $this->belongsToMany(Game::class, 'characteristic_game', 'characteristic_id', 'game_id')->withTimestamps();
	}

	public function scopeWithMoreThanHundredGames($query)
	{
		return $query->has('games', '>=', 100);
	}
}
