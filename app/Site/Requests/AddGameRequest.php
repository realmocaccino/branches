<?php
namespace App\Site\Requests;

use App\Site\Requests\BaseRequest;

class AddGameRequest extends BaseRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
    {
        return [
			'name' => 'required',
			'alias' => 'different:name',
			'release' => 'date_format:d/m/Y',
			'platforms' => 'required',
			'genres' => 'required',
			'modes' => 'required',
			'cover' => 'image|max:5000'
		];
    }
}
