<?php
namespace App\Site\Requests\Game;

use App\Site\Requests\BaseRequest;

class EditionRequestRequest extends BaseRequest
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
			'modes' => 'required'
		];
    }
}
