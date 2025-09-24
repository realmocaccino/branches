<?php
namespace App\Admin\Models;

use App\Common\Models\Base;
use App\Admin\Presenters\BasePresenter;

class Role extends Base
{
	use BasePresenter;
	
	protected $table = 'roles';
	
	protected $fillable = [
    	'name',
    	'slug',
    ];
    
    protected $hidden = [];
    
    public function administrators()
    {
		return $this->hasMany(Administrator::class);
	}
}
