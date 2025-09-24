<?php
namespace App\Admin\Services\Providers;

use App\Admin\Services\ValidationErrors;
use Illuminate\Support\ServiceProvider;

class ValidationErrorsServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $this->app->singleton(ValidationErrors::class, function($app){
        	return (new ValidationErrors())->getErrors();
        });
    }
}
