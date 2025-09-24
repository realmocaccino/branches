<?php
namespace App\Site\Controllers\Ajax;

use App\Common\Helpers\Redirect;

class RedirectController extends BaseController
{
	public function index()
	{
		if(Redirect::checkIfThereIsIntendedURL('site')) {
			return Redirect::getThenForgetIntendedURL('site');
		}
	}
}
