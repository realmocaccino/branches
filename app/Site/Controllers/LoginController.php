<?php
namespace App\Site\Controllers;

use App\Common\Helpers\Authentication;
use App\Site\Requests\LoginRequest;

class LoginController extends BaseController
{
	protected $authentication;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->authentication = new Authentication('site');
	}

	public function index()
	{
		$this->head->setTitle('Login');
		
		return $this->view('login.index');
	}
	
	public function authenticate(LoginRequest $request)
	{
		if($this->authentication->attempt($request, true)) {
			return $this->authentication->redirect('home');
		} else {
			return back()->withInput()->with('alert', 'warning|Email e senha não conferem.');
		}
	}
	
	public function logout()
	{
		$this->authentication->logout();
		
		return back();
	}
}