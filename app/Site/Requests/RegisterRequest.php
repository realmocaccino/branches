<?php
namespace App\Site\Requests;

use App\Common\Rules\{EmptyRule, UniqueRule};

class RegisterRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'name' => 'required|min:3',
			'email' => ['required', 'email', (new UniqueRule('users', 'email')), (!request()->ajax() ? 'confirmed' : null)],
			'password' => 'required|min:6',
			'terms' => 'accepted',
			'fax' => (new EmptyRule())
        ];
    }
}