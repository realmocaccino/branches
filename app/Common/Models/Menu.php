<?php
namespace App\Common\Models;

class Menu extends Base
{
    protected $table = 'menus';
    
    public function links()
    {
    	return $this->hasMany(Link::class, 'menu_id');
    }
}
