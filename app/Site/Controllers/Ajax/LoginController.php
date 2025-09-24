<?php
namespace App\Site\Controllers\Ajax;

use App\Common\Helpers\Authentication;
use App\Site\Requests\LoginRequest;

class LoginController extends BaseController
{
	public function index()
	{
		return $this->view('login_register', [
			'active' => 'login'
		])->render();
	}
	
	public function authenticate(LoginRequest $request)
	{
		$authentication = new Authentication('site');
		
		if($authentication->attempt($request, true)) {
			return response()->json([
				'header_user' => $this->view('layouts.main.header_user', [
									'user' => $authentication->user()
								])->render(),
				'side_user' => ($this->agent->isMobile() ? $this->view('layouts.main.side_user', [
									'user' => $authentication->user()
								])->render() : null)
			]);
		} else {
			return response()->json([
				'error' => 'Email e senha não conferem.'
			]);
		}
	}
}