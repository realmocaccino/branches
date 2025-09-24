<?php
namespace App\Admin\Models;

use App\Common\Models\Publisher as BasePublisher;
use App\Admin\Presenters\BasePresenter;

class Publisher extends BasePublisher
{
	use BasePresenter;
	
	protected $fillable = [
    	'name',
    	'foundation',
    	'headquarters',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

    public function games()
	{
		return parent::games();
	}
}
