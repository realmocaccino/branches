<?php
namespace App\Site\Models;

use App\Common\Models\Classification as BaseClassification;
use App\Site\Presenters\BasePresenter;

class Classification extends BaseClassification
{
	use BasePresenter;
	
    public function games()
	{
		return parent::games()->where('games.status', 1)->orderBy('games.name');
	}
}
