<?php
namespace App\Common\Middlewares;

use Closure;

class Ajax
{
	public function handle($request, Closure $next)
	{
		if(!$request->ajax()) {
		    return response('', 405);
		}

		return $next($request);
	}
}
