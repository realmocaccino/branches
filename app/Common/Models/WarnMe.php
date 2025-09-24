<?php
namespace App\Common\Models;

use Illuminate\Database\Eloquent\Model;

class WarnMe extends Model
{
	protected $table = 'warn_me';
	
	public function game()
	{
		return $this->belongsTo(Game::class, 'game_id');
	}
	
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
