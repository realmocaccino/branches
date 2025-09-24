<?php
namespace App\Site\Requests;

class LoginRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'email' => 'required|email',
			'password' => 'required'
        ];
    }
}
