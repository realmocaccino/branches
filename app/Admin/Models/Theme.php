<?php
namespace App\Admin\Models;

use App\Common\Models\Theme as BaseTheme;
use App\Admin\Presenters\BasePresenter;

class Theme extends BaseTheme
{
	use BasePresenter;
	
	protected $fillable = [
    	'name_pt',
    	'name_en',
    	'name_es',
    	'name_fr',
		'alternative_name_pt',
    	'alternative_name_en',
    	'alternative_name_es',
    	'alternative_name_fr',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

    public function games()
	{
		return parent::games();
	}
}
