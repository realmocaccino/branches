<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class AdvertisementRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validation = [
    		'name' => 'required|unique:advertisements,name,'.request('id')
    	];
    	
    	if(request('status'))
    	{
    		$validation = array_merge($validation, [
				'advertiser_id' => 'required|numeric',
				'analytics' => 'required'
			]);
			
			if(!request('responsive'))
			{
				$validation = array_merge($validation, [
					'width' => 'required',
					'height' => 'required'
				]);
			}
    	}
        
        return $validation;
    }
}
