<?php
namespace App\Console\Services\Providers;

use App\Console\Services\IgdbClientAuthenticator;

use Illuminate\Support\ServiceProvider;

class IgdbClientAuthenticatorProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $this->app->singleton(IgdbClientAuthenticator::class, function($app) {
        	return new IgdbClientAuthenticator();
        });
    }
}