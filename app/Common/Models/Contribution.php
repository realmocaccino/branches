<?php
namespace App\Common\Models;

class Contribution extends Base
{
    protected $table = 'contributions';
    
    public function game()
	{
		return $this->belongsTo(Game::class, 'game_id');
	}
    
    public function user()
    {
		return $this->belongsTo(User::class, 'user_id');
	}
}