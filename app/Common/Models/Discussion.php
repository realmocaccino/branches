<?php
namespace App\Common\Models;

class Discussion extends Base
{
    protected $table = 'discussions';
    
    public function answers()
	{
		return $this->hasMany(Answer::class, 'discussion_id');
	}
    
    public function game()
	{
		return $this->belongsTo(Game::class, 'game_id');
	}
	
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}