<?php
namespace App\Admin\Models;

use App\Common\Models\Generation as BaseGeneration;
use App\Admin\Presenters\BasePresenter;

class Generation extends BaseGeneration
{
	use BasePresenter;
	
	protected $fillable = [
    	'name',
    	'name_en',
    	'name_es',
    	'name_fr',
    	'interval',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

	public function platforms()
	{
		return parent::platforms();
	}
}
