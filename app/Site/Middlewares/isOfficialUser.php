<?php
namespace App\Site\Middlewares;

use App\Site\Helpers\Site;

use Closure;

class IsOfficialUser
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if(Site::isOfficialUser($user)) {
            return $next($request);
        }

        return redirect()->route('home')->with('message', 'warning|Você não tem permissão para acessar a página');
    }
}