<?php
namespace App\Admin\Models;

use App\Common\Models\Criteria as BaseCriteria;
use App\Admin\Presenters\BasePresenter;

class Criteria extends BaseCriteria
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
    	'description_pt',
    	'description_en',
    	'description_es',
    	'description_fr',
    	'weight',
    	'order',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

    public function scores()
    {
		return parent::scores();
	}
}
