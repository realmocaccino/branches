<?php
namespace App\Site\Models;

use App\Common\Models\Publisher as BasePublisher;
use App\Site\Presenters\BasePresenter;

class Publisher extends BasePublisher
{
	use BasePresenter;
	
    public function games()
	{
		return parent::games()->where('games.status', 1)->orderBy('games.name');
	}
}
