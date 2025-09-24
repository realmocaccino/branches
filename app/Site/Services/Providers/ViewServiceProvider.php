<?php
namespace App\Site\Services\Providers;

use App\Site\Helpers\Site;
use App\Site\Models\Settings;
use App\Site\Services\DefaultSearchGamesService;

use Detection\MobileDetect;
use Illuminate\Support\Facades\{Route, View};
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function($view) {
            $agent = new MobileDetect();
            $currentRouteName = Route::currentRouteName();
            $defaultSearchGames = resolve(DefaultSearchGamesService::class)->getFromCache();
            $isGamePage = Site::isGamePage();
            $isHeaderStatic = in_array($currentRouteName, ['add.game.index']);
            $settings = (new Settings)->get();
            
			$view->with('agent', $agent);
			$view->with('currentRouteName', $currentRouteName);
            $view->with('defaultSearchGames', $defaultSearchGames);
            $view->with('isGamePage', $isGamePage);
            $view->with('isHeaderStatic', $isHeaderStatic);
            $view->with('settings', $settings);
        });
    }

    public function register()
    {}
}