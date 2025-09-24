<?php
namespace App\Site\Presenters;

trait LinkPresenter
{
	use BasePresenter;
	
	public function getByOrder($order = 'asc')
	{
		return $this->whereStatus(1)->orderBy('order', $order)->get();
	}
}
