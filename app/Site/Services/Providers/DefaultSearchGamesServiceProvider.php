<?php
namespace App\Site\Services\Providers;

use App\Common\Services\CacheService;
use App\Site\Helpers\ListHelper;
use App\Site\Services\DefaultSearchGamesService;

use Illuminate\Support\ServiceProvider;

class DefaultSearchGamesServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $this->app->singleton(DefaultSearchGamesService::class, function($app) {
        	return (new DefaultSearchGamesService(
                $app->make(CacheService::class),
                $app->make(ListHelper::class)
            ));
        });
    }
}