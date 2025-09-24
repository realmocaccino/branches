<?php
namespace App\Site\Models;

use App\Common\Models\Menu as BaseMenu;
use App\Site\Presenters\BasePresenter;

class Menu extends BaseMenu
{
	use BasePresenter;
	
	public function links()
    {
    	return $this->hasMany(Link::class, 'menu_id');
    }
}
