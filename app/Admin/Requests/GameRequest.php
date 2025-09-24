<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class GameRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
    	$validation = [
    		'name' => 'required'
    	];
    	
    	if(request('status'))
    	{
    		$validation = array_merge($validation, [
				'release' => 'date_format:d/m/Y',
				'platforms' => 'required',
				'criterias' => 'required',
				'cover' => 'image|max:1000',
				'background' => 'image|max:1000'
			]);
    	}
        
        return $validation;
    }
}