<?php
namespace App\Admin\Models;

use App\Common\Models\Franchise as BaseFranchise;
use App\Admin\Presenters\BasePresenter;

class Franchise extends BaseFranchise
{
	use BasePresenter;
	
	protected $fillable = [
    	'name',
    	'alias',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

    public function games()
	{
		return parent::games();
	}
}
