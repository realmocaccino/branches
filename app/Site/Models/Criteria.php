<?php
namespace App\Site\Models;

use App\Common\Models\Criteria as BaseCriteria;
use App\Site\Presenters\BasePresenter;
use App\Site\Models\Traits\LocalizableTrait;

class Criteria extends BaseCriteria
{
	use BasePresenter, LocalizableTrait;
	
	public function games()
	{
		return parent::games();
	}
	
    public function scores()
    {
		return parent::scores();
	}
}