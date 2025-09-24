<?php
namespace App\Site\Models;

use App\Common\Models\Contribution as BaseContribution;
use App\Site\Presenters\BasePresenter;
use App\Site\Scopes\ValidContributionScope;

class Contribution extends BaseContribution
{
	use BasePresenter;
	
	protected static function boot()
    {
        parent::boot();
		
        static::addGlobalScope(new ValidContributionScope);
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