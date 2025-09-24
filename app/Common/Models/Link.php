<?php
namespace App\Common\Models;

class Link extends Base
{
    protected $table = 'links';
    
    public function menu()
    {
    	return $this->belongsTo(Menu::class, 'menu_id');
    }
}
