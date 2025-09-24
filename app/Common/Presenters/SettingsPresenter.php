<?php
namespace App\Common\Presenters;

trait SettingsPresenter
{
	use BasePresenter;
	
	public function get()
	{
		return $this->find(1);
	}
}
