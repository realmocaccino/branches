<?php
namespace App\Site\Models;

use App\Common\Models\Franchise as BaseFranchise;
use App\Site\Presenters\BasePresenter;

class Franchise extends BaseFranchise
{
	use BasePresenter;
	
    public function games()
	{
		return parent::games()->where('games.status', 1)->orderBy('games.name');
	}
}
