<?php
namespace App\Common\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmptyRule implements Rule
{
    public function __construct() {}

    public function passes($attribute, $value)
    {
        return empty($value);
    }
    
    public function message()
    {
    	return trans('validation.empty');
    }
}