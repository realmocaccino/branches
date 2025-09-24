<?php
namespace App\Common\Models;

class Rating extends Base
{
	protected $table = 'ratings';
    
    public function game()
    {
		return $this->belongsTo(Game::class, 'game_id');
	}
	
	public function platform()
	{
		return $this->belongsTo(Platform::class, 'platform_id');
	}
	
	public function review()
    {
    	return $this->hasOne(Review::class, 'rating_id');
    }
    
    public function scores($withCriterias = true)
    {
		return $this->hasMany(Score::class, 'rating_id')->select(['scores.*'])->when($withCriterias, function($query) {
			$query->join('criterias', 'scores.criteria_id', '=', 'criterias.id')->where('criterias.status', 1)->orderBy('criterias.order');
		});
	}
	
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}