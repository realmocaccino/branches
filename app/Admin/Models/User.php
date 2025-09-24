<?php
namespace App\Admin\Models;

use App\Common\Models\User as BaseUser;
use App\Admin\Presenters\BasePresenter;

class User extends BaseUser
{
	use BasePresenter;
	
	protected $fillable = [
    	'name',
    	'slug',
    	'email',
    	'newsletter',
    	'status',
    ];
    
    protected $hidden = [];

    public function contributions()
	{
		return parent::contributions();
	}
	
	public function platform()
	{
        return parent::platform();
    }
    
    public function ratings()
	{
		return parent::ratings();
	}
    
    public function reviews()
    {
		return parent::reviews();
	}
}