<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class PlatformRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'name' => 'required|unique:platforms,name,'.request('id'),
			'initials' => 'required|max:4|unique:platforms,initials,'.request('id'),
			'release' => 'date_format:Y',
			'logo' => 'image|max:60'
        ];
    }
}
