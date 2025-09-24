<?php
namespace App\Admin\Services\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
    	parent::boot();
    }

    public function map()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => 'App\Admin\Controllers',
        ], function ($router) {
            require base_path('routes/admin.php');
        });
    }
}
