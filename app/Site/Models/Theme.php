<?php
namespace App\Site\Models;

use App\Common\Models\Theme as BaseTheme;
use App\Site\Presenters\BasePresenter;
use App\Site\Models\Traits\LocalizableTrait;

class Theme extends BaseTheme
{
	use BasePresenter, LocalizableTrait;
	
    public function games()
	{
		return parent::games()->where('games.status', 1)->orderBy('games.name');
	}
}