<?php
namespace App\Common\Models;

class Classification extends Base
{
    protected $table = 'classifications';
    
    public function games()
	{
		return $this->hasMany(Game::class, 'classification_id');
	}
}
