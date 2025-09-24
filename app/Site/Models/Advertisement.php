<?php
namespace App\Site\Models;

use App\Common\Models\Advertisement as BaseAdvertisement;
use App\Site\Presenters\BasePresenter;

class Advertisement extends BaseAdvertisement
{
	use BasePresenter;
	
	public function advertiser()
    {
        return parent::advertiser()->where('advertisers.status', 1);
    }
}
