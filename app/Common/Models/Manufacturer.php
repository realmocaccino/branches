<?php
namespace App\Common\Models;

class Manufacturer extends Base
{
    protected $table = 'manufacturers';
    
    public function platforms()
	{
		return $this->hasMany(Platform::class, 'manufacturer_id');
	}
}
