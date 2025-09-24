<?php
namespace App\Site\Models;

use App\Common\Models\Subscription as BaseSubscription;
use App\Site\Presenters\BasePresenter;

class Subscription extends BaseSubscription
{
	use BasePresenter;
	
	public function user()
    {
		return parent::user()->where('users.status', 1);
	}
}