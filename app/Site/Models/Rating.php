<?php
namespace App\Site\Models;

use App\Common\Models\Rating as BaseRating;
use App\Site\Presenters\BasePresenter;

use Illuminate\Database\Eloquent\Builder;

class Rating extends BaseRating
{
	use BasePresenter;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('validReview', function(Builder $builder) {
            $builder->with(['game', 'platform', 'user'])->has('game')->has('user');
        });
    }
	
	public function game()
    {
		return $this->belongsTo(Game::class, 'game_id')->where('games.status', 1);
	}
	
	public function platform()
	{
		return parent::platform()->where('platforms.status', 1);
	}
	
	public function review()
    {
    	return parent::review();
    }
    
    public function scores($withCriterias = true)
    {
		return $this->hasMany(Score::class, 'rating_id')->select(['scores.*'])->when($withCriterias, function($query) {
			$query->join('criterias', 'scores.criteria_id', '=', 'criterias.id')->where('criterias.status', 1)->orderBy('criterias.order');
		});
	}
	
	public function user()
	{
		return parent::user()->where('users.status', 1);
	}
}
