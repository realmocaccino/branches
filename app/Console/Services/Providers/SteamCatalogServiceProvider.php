<?php
namespace App\Console\Services\Providers;

use App\Console\Services\SteamCatalogService;

use Illuminate\Support\ServiceProvider;

class SteamCatalogServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $this->app->singleton(SteamCatalogService::class, function($app) {
        	return new SteamCatalogService();
        });
    }
}