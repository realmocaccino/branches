<?php
namespace App\Common\Services\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
		Validator::extend('alpha_spaces', function($attribute, $value)
		{
		    return preg_match('/^[\pL\s]+$/u', $value);
		});
        Validator::extend('alpha_num_spaces', function($attribute, $value)
        {
            return preg_match('/^[\pL\s\d]+$/u', $value);
        });
    }
}
