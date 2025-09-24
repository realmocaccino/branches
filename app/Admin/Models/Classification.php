<?php
namespace App\Admin\Models;

use App\Common\Models\Classification as BaseClassification;
use App\Admin\Presenters\BasePresenter;

class Classification extends BaseClassification
{
	use BasePresenter;
	
	protected $fillable = [
    	'name',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];

    public function games()
	{
		return parent::games();
	}
}
