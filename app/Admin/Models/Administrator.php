<?php
namespace App\Admin\Models;

use App\Admin\Presenters\AdministratorPresenter;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{
	use AdministratorPresenter;

	protected $table = 'administrators';
	
	protected $fillable = [
    	'name',
    	'email',
    	'role_id',
    	'password',
    	'status',
    ];
    
    protected $hidden = [];

    public function role()
    {
		return $this->belongsTo(Role::class);
	}
}
