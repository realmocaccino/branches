<?php
namespace App\Site\Requests;

class ForgotPasswordRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'email' => 'required|email',
        ];
    }
}
