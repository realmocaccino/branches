<?php
namespace App\Site\Models;

use App\Common\Models\Developer as BaseDeveloper;
use App\Site\Presenters\BasePresenter;

class Developer extends BaseDeveloper
{
	use BasePresenter;
	
    public function games()
	{
		return parent::games()->where('games.status', 1)->orderBy('games.name');
	}
}
