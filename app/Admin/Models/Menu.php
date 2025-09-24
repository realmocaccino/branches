<?php
namespace App\Admin\Models;

use App\Common\Models\Menu as BaseMenu;
use App\Admin\Presenters\BasePresenter;

class Menu extends BaseMenu
{
    use BasePresenter;
    
    protected $fillable = [
    	'slug',
    	'name',
    	'status',
    ];
    
    protected $hidden = [];
}
