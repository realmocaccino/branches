<?php
namespace App\Site\Controllers;

use App\Site\Models\User;

class MailController extends BaseController
{
	public function unsubscribe($email)
	{
	    $user = User::whereEmail($email)->firstOrFail();
	    $user->newsletter = false;
	    $user->save();
	    
	    return redirect()->route('home')->with('alert', 'info|Você não receberá mais emails automáticos para o seu endereço de e-mail|false');
	}
}