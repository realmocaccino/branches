<?php
namespace App\Common\Models;

class Developer extends Base
{
    protected $table = 'developers';
    
    public function games()
	{
		return $this->belongsToMany(Game::class, 'developer_game', 'developer_id', 'game_id')->withTimestamps();
	}

	public function scopeWithMoreThanTwoGames($query)
	{
		return $query->has('games', '>', 2);
	}
}
