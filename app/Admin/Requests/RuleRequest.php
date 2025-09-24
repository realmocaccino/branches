<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class RuleRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
    	$validation = [
    		'title' => 'required|unique:rules,title,'.request('id')
    	];
    	
    	if(request('status'))
    	{
    		$validation = array_merge($validation, [
				'text' => 'required',
			]);
    	}
        
        return $validation;
    }
}
