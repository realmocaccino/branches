<?php
namespace App\Admin\Controllers;

use App\Common\Helpers\Authentication;
use App\Admin\Requests\LoginRequest;

class LoginController extends BaseController
{
	protected $authentication;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->authentication = new Authentication('admin');
	}

	public function index()
	{
		$this->head->setTitle('Login');
		
		return $this->view('login.index');
	}
	
	public function authenticate(LoginRequest $request)
	{
		if($this->authentication->attempt($request)) {
			return $this->authentication->redirect('home');
		} else {
			return back()->withInput()->with('message', 'danger|Email e senha não conferem');
		}
	}
	
	public function logout()
	{
		$this->authentication->logout();
		
		return redirect()->route('login.index');
	}
}
