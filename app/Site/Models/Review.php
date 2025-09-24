<?php
namespace App\Site\Models;

use App\Common\Models\Review as BaseReview;
use App\Site\Presenters\BasePresenter;

use Illuminate\Database\Eloquent\Builder;

class Review extends BaseReview
{
	use BasePresenter;
	
	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('validReview', function(Builder $builder) {
            $builder->with(['game', 'platform', 'user'])->has('game')->has('user');
        });
    }
	
	public function feedbacks()
    {
    	return parent::feedbacks();
    }
	
	public function game()
	{
		return parent::game()->where('games.status', 1);
	}
	
	public function platform()
	{
		return parent::platform()->where('platforms.status', 1);
	}
	
	public function rating()
    {
		return parent::rating();
	}

	public function scores()
	{
		return $this->hasManyThrough(Score::class, Rating::class, 'id', 'rating_id');
	}
	
	public function user()
	{
		return parent::user()->where('users.status', 1);
	}
}