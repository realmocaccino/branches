<?php
namespace App\Admin\Models;

use App\Common\Models\Manufacturer as BaseManufacturer;
use App\Admin\Presenters\BasePresenter;

class Manufacturer extends BaseManufacturer
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

    public function platforms()
	{
		return parent::platforms();
	}
}
