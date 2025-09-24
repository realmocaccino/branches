<?php
namespace App\Admin\Models;

use App\Common\Models\Contact as BaseContact;
use App\Admin\Presenters\BasePresenter;

class Contact extends BaseContact
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
    	'email',
    	'status',
    ];
    
    protected $hidden = [];
}
