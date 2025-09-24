<?php
namespace App\Admin;

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
        'permission' => \App\Admin\Middlewares\PermissionMiddleware::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
