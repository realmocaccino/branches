<?php
namespace App\Admin\Models;

use App\Common\Models\Advertiser as BaseAdvertiser;
use App\Admin\Presenters\BasePresenter;

class Advertiser extends BaseAdvertiser
{
	use BasePresenter;
	
	protected $fillable = [
    	'name',
    	'analytics',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

	public function advertisements()
    {
        return parent::advertisements();
    }
}
