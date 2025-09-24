<?php
namespace App\Site\Requests;

use App\Common\Rules\EmptyRule;

class ContactRequest extends BaseRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
    {
        return [
			'name' => 'required',
			'email' => 'required|email',
			'message' => 'required|min:' . config('site.minimum_characters_to_contact'),
			'fax' => (new EmptyRule())
		];
    }
}