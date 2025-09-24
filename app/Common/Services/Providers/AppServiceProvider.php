<?php
namespace App\Common\Services\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
    	// Timezone
		date_default_timezone_set(config('app.timezone'));

        // Use Bootstrap instead of Tailwind
        Paginator::useBootstrap();
    	
    	// Pagination for collection
    	Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
    
    public function register()
    {
    	switch(APP) {
			case 'site':
            case 'console':
                $this->app->register(\App\Site\Services\Providers\ViewServiceProvider::class);
				$this->app->register(\App\Site\Services\Providers\RouteServiceProvider::class);
                $this->app->register(\App\Site\Services\Providers\DefaultSearchGamesServiceProvider::class);
                $this->app->register(\App\Console\Services\Providers\IgdbClientAuthenticatorProvider::class);
                $this->app->register(\App\Console\Services\Providers\SteamCatalogServiceProvider::class);
			break;
			case 'admin':
				$this->app->register(\App\Admin\Services\Providers\ValidationErrorsServiceProvider::class);
				$this->app->register(\App\Admin\Services\Providers\RouteServiceProvider::class);
			break;
		}
    }
}