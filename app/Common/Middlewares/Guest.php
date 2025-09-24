<?php
namespace App\Common\Middlewares;

use Closure;
use Illuminate\Support\Facades\Auth;

class Guest
{
    public function handle($request, Closure $next, $guard)
    {
        return (Auth::guard($guard)->guest()) ? $next($request) : back();
    }
}
