<?php
namespace App\Admin\Models;

use App\Common\Models\Subscription as BaseSubscription;
use App\Admin\Presenters\BasePresenter;

class Subscription extends BaseSubscription
{
	use BasePresenter;
	
	protected $fillable = [
	    'user_id',
        'plan_id',
	    'price',
	    'expires_at'
	];
    
    protected $hidden = [];

    public function plan()
    {
        return parent::plan();
    }

    public function user()
	{
		return parent::user();
	}
}