<?php
namespace App\Admin\Models;

use App\Common\Models\Mode as BaseMode;
use App\Admin\Presenters\BasePresenter;

class Mode extends BaseMode
{
	use BasePresenter;
	
	protected $fillable = [
    	'name_pt',
    	'name_en',
    	'name_es',
    	'name_fr',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

    public function games()
	{
		return parent::games();
	}
}
