<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class InstitutionalRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
    	$validation = [
    		'slug' => 'required|unique:institutionals,slug,'.request('id')
    	];
    	
    	if(request('status'))
    	{
    		$validation = array_merge($validation, [
    			'title_pt' => 'required',
    			'title_en' => 'required',
    			'title_es' => 'required',
    			'title_fr' => 'required',
				'text_pt' => 'required',
				'text_en' => 'required',
				'text_es' => 'required',
				'text_fr' => 'required',
			]);
    	}
        
        return $validation;
    }
}
