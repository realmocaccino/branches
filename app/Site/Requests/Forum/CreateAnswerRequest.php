<?php
namespace App\Site\Requests\Forum;

use App\Site\Requests\BaseRequest;

class CreateAnswerRequest extends BaseRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
    {
        return [
			'text' => 'required'
		];
    }
}
