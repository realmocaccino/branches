<?php
namespace App\Admin\Models;

use App\Common\Models\Link as BaseLink;
use App\Admin\Presenters\BasePresenter;

class Link extends BaseLink
{
    use BasePresenter;
    
    protected $fillable = [
    	'menu_id',
    	'name_pt',
    	'name_en',
    	'name_es',
    	'name_fr',
    	'route',
    	'parameters',
    	'target',
    	'order',
    	'status',
    ];
    
    protected $hidden = [];
}
