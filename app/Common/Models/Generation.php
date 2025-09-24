<?php
namespace App\Common\Models;

class Generation extends Base
{
    protected $table = 'generations';
    
    public function platforms()
	{
		return $this->hasMany(Platform::class, 'generation_id');
	}
}
