<?php
namespace App\Site\Models;

use App\Common\Models\Advertiser as BaseAdvertiser;
use App\Site\Presenters\BasePresenter;

class Advertiser extends BaseAdvertiser
{
	use BasePresenter;
	
	public function advertisements()
    {
        return parent::advertisements()->where('advertisements.status', 1);
    }
}
