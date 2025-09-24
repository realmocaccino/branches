<?php
namespace App\Common\Models;

class Publisher extends Base
{
    protected $table = 'publishers';
    
    public function games()
	{
		return $this->belongsToMany(Game::class, 'game_publisher', 'publisher_id', 'game_id')->withTimestamps();
	}

	public function scopeWithMoreThanTwoGames($query)
	{
		return $query->has('games', '>', 2);
	}
}
