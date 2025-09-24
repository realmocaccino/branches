<?php
namespace App\Admin\Requests;

use Illuminate\Support\Facades\Auth;

use App\Admin\Requests\BaseRequest;

class AccountRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
    	$validation = [];
    	
    	if(request('account')) {
    		$validation = array_merge($validation, [
				'name' => 'required|alpha_spaces',
				'email' => 'required|email|unique:administrators,email,'.Auth::guard('admin')->id()
			]);
    	} elseif(request('password')) {
    		$validation = array_merge($validation, [
				'password' => 'required|confirmed'
			]);
    	}
        
        return $validation;
    }
}
