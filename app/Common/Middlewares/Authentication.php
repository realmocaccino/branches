<?php
namespace App\Common\Middlewares;

use App\Common\Helpers\Redirect;

use Closure;
use Illuminate\Support\Facades\{Auth, Route};

class Authentication
{
	protected $exceptRoutes = [
		'login.index',
		'login.authenticate',
		'register.index',
		'register.store',
		'register.confirm',
		'logout'
	];
	
	protected $toSavePreviousURL = [
	    'user.follow',
	    'user.unfollow'
	];

    public function handle($request, Closure $next, $guard, $withPreviousURL = false)
    {
        if(Auth::guard($guard)->check()) {
        	return $next($request);
        } else {
            $route = Route::current()->getName();
        
        	if(!in_array($route, $this->exceptRoutes)) {
        	    Redirect::putSession($guard);
        	    
        	    if(in_array($route, $this->toSavePreviousURL)) Redirect::savePreviousURL();
        	}
        	
        	return ($request->ajax()) ? redirect()->route('login.ajax.index') : redirect()->route('login.index');
        }
    }
}