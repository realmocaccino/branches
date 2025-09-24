<?php
namespace App\Common\Models;

class Theme extends Base
{
    protected $table = 'themes';
    
    public function games()
	{
		return $this->belongsToMany(Game::class, 'game_theme', 'theme_id', 'game_id')->withTimestamps();
	}

	public function scopeWithMoreThanFiftyGames($query)
	{
		return $query->has('games', '>=', 50);
	}

	public function scopeWithMoreThanHundredGames($query)
	{
		return $query->has('games', '>=', 100);
	}
}
