<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class ContactRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
    	$validation = [
    		'slug' => 'required|unique:contacts,slug,'.request('id')
    	];
    	
    	if(request('status'))
    	{
    		$validation = array_merge($validation, [
				'title_pt' => 'required',
				'title_en' => 'required',
				'title_es' => 'required',
				'title_fr' => 'required',
				'email' => 'required|email'
			]);
    	}
        
        return $validation;
    }
}
