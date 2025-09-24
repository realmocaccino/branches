<?php
namespace App\Site\Models;

use App\Common\Models\Characteristic as BaseCharacteristic;
use App\Site\Presenters\BasePresenter;
use App\Site\Models\Traits\LocalizableTrait;

class Characteristic extends BaseCharacteristic
{
	use BasePresenter, LocalizableTrait;
	
    public function games()
	{
		return parent::games()->where('games.status', 1)->orderBy('games.name');
	}
}