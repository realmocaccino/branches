<?php
namespace App\Site\Models;

use App\Common\Models\Manufacturer as BaseManufacturer;
use App\Site\Presenters\BasePresenter;

class Manufacturer extends BaseManufacturer
{
	use BasePresenter;
	
    public function platforms()
	{
		return parent::platforms()->where('platforms.status', 1)->orderBy('platforms.name');
	}
}
