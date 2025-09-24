<?php
namespace App\Site\Middlewares;

use App\Site\Helpers\Site;

use Closure;

class IsPremium
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if($user->isPremium() or Site::isOfficialUser($user)) {
            return $next($request);
        }

        return redirect()->route($request->ajax() ? 'premium.ajax.index' : 'premium.index');
    }
}