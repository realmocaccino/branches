<?php
namespace App\Site\Models;

use App\Common\Models\Discussion as BaseDiscussion;
use App\Site\Presenters\BasePresenter;

use Illuminate\Database\Eloquent\Builder;

class Discussion extends BaseDiscussion
{
    use BasePresenter;
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('validDiscussion', function(Builder $builder) {
            $builder->with('user')->has('user');
        });
    }
    
    public function answers()
	{
		return parent::answers()->where('answers.status', 1)->orderBy('answers.created_at');
	}
    
    public function game()
	{
		return parent::game()->where('games.status', 1);
	}
	
	public function user()
	{
		return parent::user()->where('users.status', 1);
	}
}