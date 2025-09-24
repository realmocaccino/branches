<?php
namespace App\Site\Requests\Forum;

use App\Site\Requests\BaseRequest;

class CreateDiscussionRequest extends BaseRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
    {
        return [
			'title' => 'required',
			'text' => 'required'
		];
    }
}
