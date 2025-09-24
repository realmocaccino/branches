<?php
namespace App\Admin\Models;

use App\Common\Models\Platform as BasePlatform;
use App\Admin\Presenters\BasePresenter;

class Platform extends BasePlatform
{
	use BasePresenter;
	
	protected $fillable = [
    	'name',
    	'initials',
    	'release',
    	'generation_id',
    	'manufacturer_id',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

    public function games()
	{
		return parent::games();
	}
	
	public function generation()
	{
		return parent::generation();
	}

	public function manufacturer()
	{
		return parent::manufacturer();
	}
	
	public function ratings()
	{
		return parent::ratings();
	}
}