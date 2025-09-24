<?php
namespace App\Site\Models;

use App\Common\Models\Platform as BasePlatform;
use App\Site\Presenters\BasePresenter;

class Platform extends BasePlatform
{
	use BasePresenter;

    public function games()
	{
		return parent::games()->where('games.status', 1)->orderBy('games.name');
	}
	
	public function generation()
	{
		return parent::generation()->where('generations.status', 1);
	}

	public function manufacturer()
	{
		return parent::manufacturer()->where('manufacturers.status', 1);
	}
	
	public function ratings()
	{
		return parent::ratings();
	}
}