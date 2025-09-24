<?php
namespace App\Site\Middlewares;

use App\Common\Helpers\Authentication;

use Closure;

class LogOutInactiveUser
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if($user and !$user->status) {
            (new Authentication('site'))->logout();

            return redirect()->route('home');
        }

        return $next($request);
    }
}