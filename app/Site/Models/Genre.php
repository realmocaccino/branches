<?php
namespace App\Site\Models;

use App\Common\Models\Genre as BaseGenre;
use App\Site\Presenters\BasePresenter;
use App\Site\Models\Traits\LocalizableTrait;

class Genre extends BaseGenre
{
	use BasePresenter, LocalizableTrait;
	
    public function games()
	{
		return parent::games()->where('games.status', 1)->orderBy('games.name');
	}
}