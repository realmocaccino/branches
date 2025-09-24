<?php
namespace App\Site\Requests\Add;

use App\Site\Requests\BaseRequest;

class SearchRequest extends BaseRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
    {
        return [
			'name' => 'required'
		];
    }
}
