<?php
namespace App\Admin\Models;

use App\Common\Models\Advertisement as BaseAdvertisement;
use App\Admin\Presenters\BasePresenter;

class Advertisement extends BaseAdvertisement
{
	use BasePresenter;
	
	protected $fillable = [
    	'name',
    	'advertiser_id',
    	'analytics',
    	'platform',
    	'responsive',
    	'width',
    	'height',
    	'style',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

	public function advertiser()
    {
        return parent::advertiser();
    }
}
