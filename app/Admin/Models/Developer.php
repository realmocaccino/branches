<?php
namespace App\Admin\Models;

use App\Common\Models\Developer as BaseDeveloper;
use App\Admin\Presenters\BasePresenter;

class Developer extends BaseDeveloper
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
