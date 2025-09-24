<?php
namespace App\Site\Controllers;

use App\Site\Models\User;
use App\Site\Requests\{ForgotPasswordRequest, RedefinePasswordRequest};
use App\Site\Mails\RedefinePasswordMail;
use App\Common\Helpers\Authentication;

use Illuminate\Support\Facades\Mail;

class PasswordController extends BaseController
{
	public function forgotPasswordPage()
	{
		$this->head->setTitle(trans('password/forgot_password.title'));
		
		return $this->view('password.forgot_password');
	}
	
	public function redefinePasswordPage($token)
	{
		$user = User::whereToken($token)->firstOrFail();
	
		$this->head->setTitle(trans('password/redefine_password.title'));
		
		return $this->view('password.redefine_password', [
			'token' => $token
		]);
	}
	
	public function sendToken(ForgotPasswordRequest $request)
	{
		$user = User::whereEmail($request->email)->first();
	
		if($user) {
			$token = str_random(40);
			
			$user->token = $token;
			$user->save();
			
			Mail::to($user)->send(new RedefinePasswordMail($user));
	
			return redirect()->route('home')->with('alert', 'info|' . trans('password/forgot_password.alert_email_sent') . '|false');
		} else {
			return back()->with('alert', 'warning|' . trans('password/forgot_password.alert_email_not_found'));
		}
	}
	
	public function redefinePassword(RedefinePasswordRequest $request)
	{
		$user = User::whereToken($request->token)->firstOrFail();
		$user->token = null;
		$user->password = bcrypt($request->password);
		$user->save();
		
		$authentication = new Authentication('site');
		$authentication->login($user, true);
		
		return redirect()->route('home')->with('alert', 'success|' . trans('password/forgot_password.alert_password_reset'));
	}
}
