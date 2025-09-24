<?php
namespace App\Site;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
	/*
     * Global Middlewares
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \App\Common\Middlewares\EncryptCookies::class,
    ];
    
    /*
     * Group Middlewares
     */
    protected $middlewareGroups = [
        'web' => [
        	\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        	\Illuminate\View\Middleware\ShareErrorsFromSession::class,
        	\App\Common\Middlewares\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Site\Middlewares\SetLanguage::class,
            \App\Site\Middlewares\SetLastAccessAndIpToUser::class,
            \App\Site\Middlewares\LogOutInactiveUser::class,
        ],
        'premium' => [
            'auth:site',
            \App\Site\Middlewares\IsPremium::class
        ],
        'isNotDefaultCollection' => [
            'auth:site',
            \App\Site\Middlewares\isNotDefaultCollection::class
        ],
        'isNotPremium' => [
            'auth:site',
            \App\Site\Middlewares\IsNotPremium::class
        ],
        'isOfficialUser' => [
            'auth:site',
            \App\Site\Middlewares\isOfficialUser::class
        ],
    ];
    
    /*
     * Single Middlewares
     */
    protected $routeMiddleware = [
    	'ajax' => \App\Common\Middlewares\Ajax::class,
    	'auth' => \App\Common\Middlewares\Authentication::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Common\Middlewares\Guest::class,
        'checkGameAvailability' => \App\Site\Middlewares\CheckGameAvailability::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'blockIp' => \App\Site\Middlewares\BlockIp::class
    ];
}
