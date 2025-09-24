<?php
namespace App\Site\Services\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    private $forbiddenParameterValues = [
        'manifest.json',
        'service-worker.js'
    ];

    public function boot()
    {
    	parent::boot();

        Route::bind('slug', function ($value, $route) {
            $this->abortIfParameterValueIsForbidden($value);

            return $value;
        });
    }

    public function map()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => 'App\Site\Controllers',
        ], function ($router) {
            require base_path('routes/site.php');
        });
    }

    private function abortIfParameterValueIsForbidden($value)
    {
        return in_array($value, $this->forbiddenParameterValues) ? abort(404) : null;
    }
}