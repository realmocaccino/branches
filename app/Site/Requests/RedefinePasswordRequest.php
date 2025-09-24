<?php
namespace App\Site\Requests;

class RedefinePasswordRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'password' => 'required|confirmed'
        ];
    }
}
