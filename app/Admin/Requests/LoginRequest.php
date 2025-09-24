<?php
namespace App\Admin\Requests;

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
