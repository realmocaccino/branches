<?php
namespace App\Common\Models;

class Mode extends Base
{
    protected $table = 'modes';
    
    public function games()
	{
		return $this->belongsToMany(Game::class, 'game_mode', 'mode_id', 'game_id')->withTimestamps();
	}
}
