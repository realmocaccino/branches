<?php
namespace App\Admin\Models;

use App\Common\Models\Rating as BaseRating;
use App\Admin\Presenters\RatingPresenter;

class Rating extends BaseRating
{
	use RatingPresenter;
	
	protected $fillable = [
		'game_id',
		'platform_id',
		'user_id'
	];
    
    protected $hidden = [];

	public function game()
    {
		return parent::game();
	}
	
	public function platform()
	{
		return parent::platform();
	}
	
	public function review()
    {
    	return parent::review();
    }
    
    public function scores($withCriterias = true)
    {
		return parent::scores($withCriterias);
	}
	
	public function user()
	{
		return parent::user();
	}
}
