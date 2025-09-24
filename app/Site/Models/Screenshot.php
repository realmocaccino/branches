<?php
namespace App\Site\Models;

use App\Common\Models\Screenshot as BaseScreenshot;
use App\Site\Presenters\BasePresenter;

class Screenshot extends BaseScreenshot
{
	use BasePresenter;
	
	public function game()
    {
		return parent::game()->where('games.status', 1);
	}
}
