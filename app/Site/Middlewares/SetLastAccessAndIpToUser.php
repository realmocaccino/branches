<?php
namespace App\Site\Middlewares;

use Closure;

class SetLastAccessAndIpToUser
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        
        if($user and $user->last_access->lt(today())) {
            $user->last_access = now();
            $user->ip = $request->ip();
            $user->timestamps = false;
            $user->save();
        }
    	
        return $next($request);
    }
}