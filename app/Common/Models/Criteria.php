<?php
namespace App\Common\Models;

class Criteria extends Base
{
	protected $table = 'criterias';
	
    public function games()
	{
		return $this->belongsToMany(Game::class, 'criteria_game', 'criteria_id', 'game_id')->withTimestamps();
	}
    
    public function scores()
    {
		return $this->hasMany(Score::class, 'criteria_id');
	}
}
