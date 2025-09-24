<?php
namespace App\Admin\Models;

use App\Common\Models\Plan as BasePlan;
use App\Admin\Presenters\BasePresenter;

class Plan extends BasePlan
{
	use BasePresenter;
	
	protected $fillable = [
	    'name',
	    'price',
	    'days'
	];
    
    protected $hidden = [];

    public function subscriptions()
    {
        return parent::subscriptions();
    }
}