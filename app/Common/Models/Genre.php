<?php
namespace App\Common\Models;

class Genre extends Base
{
    protected $table = 'genres';

    public function games()
	{
		return $this->belongsToMany(Game::class, 'game_genre', 'genre_id', 'game_id')->withTimestamps();
	}
}
