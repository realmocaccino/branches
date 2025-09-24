<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class AdministratorRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
    	$validation = [
			'name' => 'required|alpha_spaces',
			'email' => 'required|email|unique:administrators,email,'.request('id'),
			'role_id' => 'required'
        ];
    	
    	if(!request('_method'))
    	{
    		$validation = array_merge($validation, [
				'password' => 'required|confirmed',
			]);
    	}
        
        return $validation;
    }
}
