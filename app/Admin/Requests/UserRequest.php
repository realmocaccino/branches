<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class UserRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'name' => 'required|alpha_num_spaces',
        	'slug' => 'required|unique:users,slug,'.request('id'),
			'email' => 'required|email|unique:users,email,'.request('id')
        ];
    }
}
