<?php
namespace App\Common\Helpers;

use App\Common\Helpers\Redirect;

use Illuminate\Support\Facades\Auth;

class Authentication
{
	protected $auth;
	protected $guard;

	public function __construct($guard)
	{
		$this->guard = $guard;
		$this->auth = Auth::guard($this->guard);
	}

	public function attempt($request, $remember = false)
	{
		return $this->auth->attempt([
			'email' => $request->email,
			'password' => $request->password,
			'status' => 1,
			'deleted_at' => null
		], $remember);
	}
	
	public function login($instance, $remember = false)
	{
		return $this->auth->login($instance, $remember);
	}
	
	public function logout()
	{
		$this->auth->logout();
	}
	
	public function redirect($route, $parameters = [])
	{
		if(Redirect::checkIfThereIsIntendedURL($this->guard)) {
			return redirect(Redirect::getThenForgetIntendedURL($this->guard));
		} else {
			return redirect()->route($route, $parameters);
		}
	}
	
	public function user()
	{
		return $this->auth->user();
	}
}
