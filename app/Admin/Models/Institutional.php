<?php
namespace App\Admin\Models;

use App\Common\Models\Institutional as BaseInstitutional;
use App\Admin\Presenters\BasePresenter;

class Institutional extends BaseInstitutional
{
	use BasePresenter;
	
	protected $fillable = [
    	'slug',
    	'title_pt',
    	'title_en',
    	'title_es',
    	'title_fr',
    	'description_pt',
    	'description_en',
    	'description_es',
    	'description_fr',
    	'text_pt',
    	'text_en',
    	'text_es',
    	'text_fr',
    	'status',
    ];
    
    protected $hidden = [];
}
