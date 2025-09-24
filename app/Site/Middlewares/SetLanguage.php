<?php
namespace App\Site\Middlewares;

use App\Site\Helpers\LanguageHelper;

use Closure;

class SetLanguage 
{
    private $helper;

    public function __construct(LanguageHelper $helper)
    {
        $this->helper = $helper;
    }

    public function handle($request, Closure $next)
    {
        $this->helper->determineLanguage($request);

        if($this->helper->isSupposedToSetCookie()) {
            return $next($request)->withCookie($this->helper->getCookie());
        }
    	
        return $next($request);
    }
}