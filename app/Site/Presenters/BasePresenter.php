<?php
namespace App\Site\Presenters;

use App\Common\Presenters\BasePresenter as Presenter;
use App\Site\Scopes\ActiveScope;

trait BasePresenter
{
	use Presenter;
	
	protected static function boot()
    {
        parent::boot();
		
        static::addGlobalScope(new ActiveScope);
    }
}
