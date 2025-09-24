<?php
namespace App\Site\Models;

use App\Common\Models\Mode as BaseMode;
use App\Site\Presenters\BasePresenter;
use App\Site\Models\Traits\LocalizableTrait;
use App\Site\Scopes\ModeOrderScope;

class Mode extends BaseMode
{
	use BasePresenter, LocalizableTrait;
	
	protected static function boot()
    {
        parent::boot();
		
        static::addGlobalScope(new ModeOrderScope);
    }
	
    public function games()
	{
		return parent::games()->where('games.status', 1)->orderBy('games.name');
	}
}