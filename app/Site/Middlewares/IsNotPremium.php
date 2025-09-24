<?php
namespace App\Site\Middlewares;

use Closure;

class IsNotPremium
{
    public function handle($request, Closure $next)
    {
        if($request->user()->isPremium()) {
            return redirect()->route($request->ajax() ? 'premium.ajax.index' : 'premium.index');
        }

        return $next($request);
    }
}