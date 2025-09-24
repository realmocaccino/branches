<?php
namespace App\Admin\Presenters;

trait AdministratorPresenter
{
	use BasePresenter;
	
	public function isAdmin()
	{
		return (bool) ($this->role->slug == 'administrator');
	}
	
	public function isEditor()
	{
		return (bool) ($this->role->slug == 'editor');
	}
}
