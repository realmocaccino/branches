<?php
namespace App\Admin\Models;

use App\Common\Models\Rule as BaseRule;
use App\Admin\Presenters\BasePresenter;

class Rule extends BaseRule
{
	use BasePresenter;
	
	protected $fillable = [
    	'slug',
    	'title',
    	'description',
    	'text',
    	'status',
    ];
    
    protected $hidden = [];
}
