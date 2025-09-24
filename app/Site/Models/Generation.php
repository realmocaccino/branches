<?php
namespace App\Site\Models;

use App\Common\Models\Generation as BaseGeneration;
use App\Site\Presenters\BasePresenter;

class Generation extends BaseGeneration
{
	use BasePresenter;
	
	public function platforms()
	{
		return parent::platforms()->where('platforms.status', 1)->orderBy('platforms.name');
	}
}
