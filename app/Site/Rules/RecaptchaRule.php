<?php
namespace App\Site\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;

class RecaptchaRule implements Rule
{
    public function __construct() {}

    public function passes($attribute, $value)
    {
        $response = (new Client)->post('https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' =>
                    [
                        'secret' => config('services.recaptcha.secret_key'),
                        'response' => $value
                    ]
            ]
        );
        $body = json_decode((string) $response->getBody());
        
        return $body->success;
    }
    
    public function message()
    {
    	return null;
    }
}