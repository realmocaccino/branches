<?php
namespace App\Site\Models;

use App\Common\Models\WarnMe as BaseWarnMe;

class WarnMe extends BaseWarnMe
{
	protected $fillable = [
		'game_id',
		'user_id',
		'sent'
	];
	
	public function game()
	{
		return parent::game();
	}
	
	public function user()
	{
		return parent::user();
	}
}
