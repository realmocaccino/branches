<?php
namespace App\Admin\Middlewares;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
	public function handle($request, Closure $next, $role)
    {
    	$auth = Auth::guard('admin');
    	
        if($auth->check() and isset($auth->user()->role) and $auth->user()->role->slug == $role) {
        	return $next($request);
        } else {
        	return redirect()->route('home')->with('message', 'warning|Você não tem permissão para acessar a página'); 
		}
    }
}
